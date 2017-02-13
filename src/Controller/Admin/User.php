<?php

namespace Miaoxing\User\Controller\Admin;

use Miaoxing\Plugin\Service\User as UserService;

class User extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '用户管理';

    protected $actionPermissions = [
        'index' => '列表',
        'edit,update,moveGroup' => '编辑',
        'destroy' => '删除',
        'show' => '查看',
        'ref' => '来源统计',
    ];

    protected $guestPages = [
        'admin/user/keepLogin',
    ];

    /**
     * 展示用户列表
     */
    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
            case 'csv':
                $users = wei()->user();
                $users->select('user.*');

                // 分页
                $users->limit($req['rows'])->page($req['page']);

                // 排序
                $users->desc('user.id');

                // 用户筛选
                $this->event->trigger('preUserSearch', [$users, $req]);

                // 根据关注状态显示用户
                switch (true) {
                    case $req['isValid'] === '1':
                        $users->andWhere(['user.isValid' => true]);
                        break;

                    case $req['isValid'] === '0':
                        $users->andWhere(['user.isValid' => false]);
                        break;
                }

                // 平台筛选
                // TODO 如何移到插件中
                if ($req['platform'] == 'self') {
                    $users->andWhere([
                        'wechatOpenId' => '',
                        'qqOpenId' => '',
                    ]);
                }

                // 分组筛选
                if (wei()->isPresent($req['groupId'])) {
                    $users->andWhere('user.groupId = ?', (string) $req['groupId']);
                }

                // 昵称,姓名
                foreach (['nickName', 'name'] as $field) {
                    if (isset($req[$field])) {
                        $users->andWhere('user.' . $field . ' LIKE ?', '%' . $req[$field] . '%');
                    }
                }

                // 手机号单独查询
                if (isset($req['mobile'])) {
                    $users->andWhere('user.mobile LIKE ?', $req['mobile'] . '%');
                }

                // 兼容老的搜索,如userPicker,待移除
                if ($req['search']) {
                    $users->andWhere(
                        '(user.nickName LIKE ?) OR (user.mobile = ?)',
                        ['%' . $req['search'] . '%', $req['search']]
                    );
                }

                // 导出用户限制
                if ($req['format'] == 'csv' && $users->count() > 10000) {
                    return $this->err('导出用户数超过1W，请联系开发人员后台导出！');
                }

                // 触发查找前事件
                $this->event->trigger('preAdminUserListFind', [$req, $users]);

                $data = [];
                $score = wei()->score;
                foreach ($users->findAll() as $user) {
                    $weChatQrcode = wei()->weChatQrcode()->where('sceneId=?', $user['source'])->find();
                    $source = '';
                    if ($weChatQrcode) {
                        $source = $weChatQrcode->getUser();
                    }

                    $user['score'] = $score->getScore($user);
                    $data[] = $user->toArray() + [
                            'sourceUser' => $source ? $source->toArray() : '',
                            'group' => $user->getGroup(),
                        ];
                }

                if ($req['_format'] == 'csv') {
                    return $this->renderCsv($data);
                } else {
                    return $this->suc([
                        'data' => $data,
                        'page' => (int) $req['page'],
                        'rows' => (int) $req['rows'],
                        'records' => $users->count(),
                    ]);
                }

            default:
                $groups = wei()->group()->findAll()->withUngroup();

                // 获取用户相关平台
                $platforms[] = [
                    'name' => '直接注册',
                    'value' => 'self',
                ];
                $this->event->trigger('userGetPlatform', [&$platforms]);

                return get_defined_vars();
        }
    }

    public function editAction($req)
    {
        $user = wei()->user()->findId($req['id']);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $user = wei()->user()->findId($req['id']);
        $user->save($req);

        return $this->suc();
    }

    public function newAction($req)
    {
        return $this->userinfoAction($req);
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function destroyAction($req)
    {
        $user = wei()->user()->findOneById($req['id']);

        if ($user['id'] == $this->curUser['id']) {
            return $this->err('不能删除自己');
        }

        $user->destroy();

        return $this->suc();
    }

    public function showAction($req)
    {
        $user = wei()->user()->findOneById($req['id']);

        // 允许插件附加更多信息
        $data = $user->toArray();
        $this->event->trigger('adminUserShow', [$user, &$data]);

        $data['isRegionLocked'] = $user->isStatus(UserService::STATUS_REGION_LOCKED);
        $data['isMobileVerified'] = $user->isStatus(UserService::STATUS_MOBILE_VERIFIED);

        return $this->suc([
            'data' => $data,
        ]);
    }

    /**
     * 将用户移动到新分组
     */
    public function moveGroupAction($req)
    {
        $validator = wei()->validate([
            // 待验证的数据
            'data' => [
                'groupId' => $req['groupId'],
                'ids' => $req['ids'],
            ],
            // 验证规则数组
            'rules' => [
                'groupId' => [
                    'required' => true,
                ],
                'ids' => [
                    'required' => true,
                ],
            ],
            // 数据项名称的数组,用于错误信息提示
            'names' => [
                'groupId' => '分组Id',
                'ids' => '用户Ids',
            ],
        ]);
        if (!$validator->isValid()) {
            $firstMessage = $validator->getFirstMessage();

            return json_encode(['code' => -7, 'message' => $firstMessage]);
        }

        $group = wei()->group()->findOrInitById($req['groupId']);
        $ret = wei()->event->until('groupMove', [$req['ids'], $group]);
        if ($ret) {
            return $this->ret($ret);
        }

        // 本地保存
        $users = wei()->user()->where(['id' => $req['ids']]);
        $users->update(['groupId' => (int) $req['groupId']]);

        return $this->suc();
    }

    protected function renderCsv($users)
    {
        $sources = [
            -1 => '后台创建',
        ];

        $genders = [
            0 => '未知',
            1 => '男',
            2 => '女',
        ];

        $data = [];
        $data[0] = ['姓名', '昵称', '手机', '性别', '国家', '省份', '城市', '来源', '注册时间', '是否关注', '取关时间'];

        foreach ($users as $user) {
            // TODO #970
            if ($user['sourceUser']) {
                $source = $user['sourceUser']['name'] ?: $user['sourceUser']['nickName'];
            } elseif (isset($sources[$user['source']])) {
                $source = $sources[$user['source']];
            } else {
                $source = '直接注册';
            }

            $data[] = [
                $user['name'],
                $user['nickName'] . ' ', // TODO 和订单等统一处理
                $user['mobile'],
                $genders[(int) $user['gender']],
                $user['country'],
                $user['province'],
                $user['city'],
                $source,
                $user['createTime'],
                $user['isValid'] ? '是' : '否',
                $user['unsubscribeTime'],
            ];
        }

        return wei()->csvExporter->export('users', $data);
    }

    /**
     * 展示个人信息
     */
    public function userinfoAction($req)
    {
        $user = wei()->user()->findId($req['id']);

        $isMobileVerified = $user->isStatus(UserService::STATUS_MOBILE_VERIFIED);
        $isRegionLocked = $user->isStatus(UserService::STATUS_REGION_LOCKED);

        return get_defined_vars();
    }

    /**
     * 保存个人数据
     */
    public function editUserAction($req)
    {
        // 1. 校验数据
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'mobile' => [
                    'required' => false,
                    'mobileCn' => true,
                ],
            ],
            'names' => [
                'mobile' => '手机号码',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        // 检查认证手机号码是否已存在
        $user = wei()->user()->findId($req['id']);
        if ($req['isMobileVerified']) {
            $ret = $user->checkMobile($req['mobile']);
            if ($ret['code'] !== 1) {
                return $ret;
            }
        }

        // 2. 保存数据
        if (isset($req['isRegionLocked'])) {
            $user->setStatus(UserService::STATUS_REGION_LOCKED, $req['isRegionLocked']);
        }

        if (isset($req['isMobileVerified'])) {
            $user->setStatus(UserService::STATUS_MOBILE_VERIFIED, $req['isMobileVerified']);
        }

        // TODO 待和来源功能一起升级
        if ($user->isNew()) {
            $user['source'] = '-1';
        }

        $user->save($req);

        return $this->suc();
    }

    /**
     * 用户来源统计
     *
     * @todo 1. 重写代码逻辑 2.移出user模块
     */
    public function refAction($req)
    {
        switch ($req['_format']) {
            case 'json':
            case 'csv':
                $userRef = wei()->user()->select('count(*) as total,user.source');
                $userRef->groupBy('user.source');
                if ($req['startTime']) {
                    $userRef->andWhere('user.createTime>=?', $req['startTime']);
                }
                if ($req['endTime']) {
                    $userRef->andWhere('user.createTime<=?', $req['endTime']);
                }
                $userRef = $userRef->fetchAll();

                $createdByAdmin = [
                    'id' => 0,
                    'name' => '后台创建',
                    'count' => 0,
                    'user' => null,
                ];

                $userRefData = [
                    0 => [
                        'id' => 0,
                        'name' => '直接关注',
                        'count' => 0,
                        'user' => null,
                    ],
                ];
                foreach ($userRef as $key => $value) {
                    $weChatQrcode = wei()->weChatQrcode()->where('sceneId=?', $value['source']);
                    $weChatQrcode = $weChatQrcode->fetch();
                    if ($weChatQrcode) {
                        $user = wei()->user()->findById($weChatQrcode['userId']);
                        $userRefData[] = [
                            'id' => $value['source'],
                            'name' => $weChatQrcode['name'],
                            'count' => $value['total'],
                            'user' => $user ? $user->toArray() : null,
                        ];
                    } elseif ($value['source'] == '-1') {
                        ++$createdByAdmin['count'];
                    } else {
                        $userRefData[0]['count'] += $value['total'];
                    }
                }

                $userRefData[] = $createdByAdmin;

                $sort = $req['sort'] ?: 'id';
                if (isset($userRefData[0][$sort])) {
                    $order = $req['order'] == 'desc' ? SORT_DESC : SORT_ASC;
                    $userRefData = wei()->coll->orderBy($userRefData, $sort, $order);
                }

                if ($req['_format'] == 'json') {
                    return $this->suc([
                        'data' => $userRefData,
                        'page' => (int) $req['page'],
                        'rows' => (int) $req['rows'],
                        'records' => count($userRefData),
                    ]);
                } else {
                    return $this->renderRefCsv($userRefData);
                }

            default:
                return get_defined_vars();
        }
    }

    protected function renderRefCsv($userRefData)
    {
        $data = [];
        $data[0] = ['场景编号', '来源名称', '数量', '所属用户'];

        foreach ($userRefData as $row) {
            $data[] = [
                $row['id'] ?: '-',
                $row['name'],
                $row['count'],
                $row['user'] ? ($row['user']['name'] ?: $row['user']['nickName']) : '-',
            ];
        }

        return wei()->csvExporter->export('user-ref', $data);
    }

    /**
     * 保持用户在登录态
     */
    public function keepLoginAction()
    {
        if (wei()->curUser->isLogin()) {
            return $this->suc();
        } else {
            return $this->err('未登录');
        }
    }

    public function autoCompleteAction($req)
    {
        $search = '%' . $req['term'] . '%';
        $users = wei()->user()
            ->where('nickName LIKE ? OR name LIKE ?', [$search, $search])
            ->limit(10)
            ->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user['id'],
                'label' => $user->getNickName(),
                'value' => $user->getNickName(),
            ];
        }

        return $this->response->json($data);
    }
}
