<?php

namespace Miaoxing\User\Service;

use Miaoxing\App\Service\GroupModel;
use Miaoxing\App\Service\UserModel as BaseUserModel;
use Miaoxing\Plugin\Service\Ret;
use Wei\Time;

/**
 * @property int $score 积分
 * @property string $money 账户余额
 * @property string $rechargeMoney 充值账户余额
 * @property string $source 用户来源
 * @property bool $isMobileVerified
 * @property string|null $id
 * @property string $appId
 * @property string $outId
 * @property int $adminType 管理员类型
 * @property string $groupId 用户组
 * @property bool $isAdmin
 * @property string $nickName
 * @property string $remarkName
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string|null $mobileVerifiedAt 手机校验时间
 * @property string $phone
 * @property string $password
 * @property int $sex
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $signature
 * @property bool $isEnabled 是否启用
 * @property string $avatar
 * @property string|null $lastLoginAt
 * @property string|null $createdAt
 * @property string|null $updatedAt
 * @property string $createdBy
 * @property string $updatedBy
 * @property string|null $displayName
 */
class UserModel extends BaseUserModel
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->virtual = array_merge($this->virtual, [
            'isMobileVerified',
        ]);
    }

    public function getBackendDisplayName()
    {
        if ($this['name'] && $this['nickName']) {
            return $this['name'] . '(' . $this['nickName'] . ')';
        } elseif ($this['name']) {
            return $this['name'];
        } else {
            return $this['nickName'];
        }
    }

    /**
     * Repo: 根据用户编号,从缓存中获取用户名
     *
     * @param int $id
     * @return string
     */
    public function getDisplayNameByIdFromCache($id)
    {
        return wei()->arrayCache->remember('nickName' . $id, static function () use ($id) {
            $user = wei()->user()->find(['id' => $id]);

            return $user ? $user->getNickName() : '';
        });
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->removeModelCache();
    }

    public function afterDestroy()
    {
        parent::afterDestroy();
        $this->removeModelCache();
    }

    /**
     * Record: 移动用户分组
     *
     * @param int $groupId
     * @return array
     */
    public function updateGroup($groupId)
    {
        $group = GroupModel::findOrInit($groupId);
        $ret = wei()->event->until('groupMove', [[$this['id']], $group]);
        if ($ret) {
            return $ret;
        }

        $this->save(['groupId' => $groupId]);

        return $this->suc();
    }

    /**
     * Record: 创建一个新用户
     *
     * wei()->user()->register([
     *     'email' => 'xx', // 可选
     *     'username' => 'xx',
     *     'password' => 'xx',
     *     'passwordAgain' => 'xx,
     *     'source' => 1, // 来源,可选
     * ]);
     *
     * @param array $data
     * @return array
     * @todo 太多validate,需简化
     */
    public function register($data)
    {
        // 1. 校验额外数据
        if (isset($data['mobile'])) {
            $validator = wei()->validate([
                'data' => $data,
                'rules' => [
                    'mobile' => [
                        'required' => true,
                        'mobileCn' => true,
                    ],
                    'verifyCode' => [
                        'required' => true,
                    ],
                ],
                'names' => [
                    'mobile' => '手机号码',
                    'verifyCode' => '验证码',
                ],
                'messages' => [
                    'mobile' => [
                        'required' => '请输入手机号码',
                    ],
                    'verifyCode' => [
                        'required' => '请输入验证码',
                    ],
                ],
            ]);
            if (!$validator->isValid()) {
                return ['code' => -1, 'message' => $validator->getFirstMessage()];
            }

            $ret = wei()->verifyCode->check($data['mobile'], $data['verifyCode']);
            if (1 !== $ret['code']) {
                return $ret + ['verifyCodeErr' => true];
            }
        } else {
            $validator = wei()->validate([
                'data' => $data,
                'rules' => [
                    'email' => [
                        'required' => true,
                    ],
                ],
                'names' => [
                    'email' => '邮箱',
                ],
                'messages' => [
                    'email' => [
                        'required' => '请输入邮箱',
                    ],
                ],
            ]);
            if (!$validator->isValid()) {
                return ['code' => -1, 'message' => $validator->getFirstMessage()];
            }
        }

        // 2. 统一校验
        $validator = wei()->validate([
            'data' => $data,
            'rules' => [
                'email' => [
                    'required' => false,
                    'email' => true,
                    'notRecordExists' => ['user', 'email'],
                ],
                'password' => [
                    'minLength' => 6,
                ],
                'passwordConfirm' => [
                    'equalTo' => $data['password'],
                ],
            ],
            'names' => [
                'email' => '邮箱',
                'password' => '密码',
            ],
            'messages' => [
                'passwordConfirm' => [
                    'required' => '请再次输入密码',
                    'equalTo' => '两次输入的密码不相等',
                ],
            ],
        ]);
        if (!$validator->isValid()) {
            return ['code' => -7, 'message' => $validator->getFirstMessage()];
        }

        if ($data['mobile']) {
            $user = wei()->user()->mobileVerified()->find(['mobile' => $data['mobile']]);
            if ($user) {
                return ['code' => -8, 'message' => '手机号码已存在'];
            }
        }

        $ret = $this->event->until('userRegisterValidate', [$this]);
        if ($ret) {
            return $ret;
        }

        // 3. 保存到数据库
        $this->setPlainPassword($data['password']);

        if ($data['mobile']) {
            $this->setMobileVerified();
        }

        $this->save([
            'email' => (string) $data['email'],
            'mobile' => (string) $data['mobile'],
            'username' => (string) $data['username'],
            'source' => isset($data['source']) ? $data['source'] : '',
        ]);

        return ['code' => 1, 'message' => '注册成功'];
    }

    public function isMobileExists($mobile)
    {
        return (bool) wei()->userModel()
            ->where('mobile', $mobile)
            ->where('id', '!=', $this->id)
            ->fetchColumn();
    }

    /**
     * QueryBuilder: 查询手机号码验证过
     *
     * @return $this
     */
    public function mobileVerified()
    {
        return $this->whereNotNull('mobileVerifiedAt');
    }

    /**
     * @param bool $verified
     * @return $this
     */
    public function setMobileVerified($verified = true)
    {
        $this->mobileVerifiedAt = $verified ? Time::now() : null;
        return $this;
    }

    public function updateMobileIfVerified($save = true, $req = null)
    {
        $req || $req = $this->req;

        // 未校验,或者是输入了新手机,需要校验
        if (
            !$this->isMobileVerified()
            || $this['mobile'] != $req['mobile']
        ) {
            $ret = $this->checkMobile($req['mobile']);
            if (1 !== $ret['code']) {
                return $ret;
            }

            if (!$req['verifyCode']) {
                return $this->err('验证码不能为空');
            }

            $ret = wei()->verifyCode->check($req['mobile'], $req['verifyCode']);
            if (1 !== $ret['code']) {
                return $ret + ['verifyCodeErr' => true];
            }
        }

        if ($this['mobile'] == $req['mobile']) {
            return $this->suc(['changed' => false]);
        }

        $this['mobile'] = $req['mobile'];
        $this->setMobileVerified();
        if ($save) {
            $this->save();
        }
        return $this->suc(['changed' => true]);
    }

    /**
     * Repo: 记录用户操作日志
     *
     * @param string $action
     * @param array $data
     * @return $this
     */
    public function log($action, array $data)
    {
        /** @phpstan-ignore-next-line */
        $user = User::cur();
        $app = wei()->app;

        if (isset($data['param']) && is_array($data['param'])) {
            $data['param'] = json_encode($data['param'], \JSON_UNESCAPED_UNICODE);
        }

        if (isset($data['ret']) && is_array($data['ret'])) {
            $data['ret'] = json_encode($data['ret'], \JSON_UNESCAPED_UNICODE);
        }

        wei()->db->insert('userLogs', $data + [
                'appId' => $app->getId(),
                'userId' => $user->id,
                'nickName' => $user->nickName,
                'page' => $app->getControllerAction(),
                'action' => $action,
                'createTime' => date('Y-m-d H:i:s'),
            ]);

        return $this;
    }

    public function getTags()
    {
        $userTags = wei()->userTag->getAll();
        $tags = [];
        $relations = wei()->userTagsUserModel()->asc('id')->findAll(['user_id' => $this['id']]);
        foreach ($relations as $relation) {
            $tags[] = $userTags[$relation->tagId];
        }
        return $tags;
    }

    public function getIsMobileVerifiedAttribute()
    {
        return (bool) $this->mobileVerifiedAt;
    }

    public function setIsMobileVerifiedAttribute()
    {
        // do nothing
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return (isset($this->attributes['avatar']) && $this->attributes['avatar']) ?
            $this->attributes['avatar'] : $this->user->defaultAvatar;
    }

    /**
     * QueryBuilder:
     *
     * @return \Miaoxing\Plugin\Service\UserModel
     */
    public function valid()
    {
        return $this->where(['isValid' => 1]);
    }

    /**
     * Record: 检查指定的手机号码能否绑定当前用户
     *
     * @param string $mobile
     * @return Ret
     * @svc
     */
    protected function checkMobile(string $mobile)
    {
        if (!$mobile) {
            return err('手机不能为空');
        }

        // 1. 检查是否已存在认证该手机号码的用户
        $mobileUser = static::new()->mobileVerified()->findBy('mobile', $mobile);
        if ($mobileUser && $mobileUser['id'] != $this['id']) {
            return err('已存在认证该手机号码的用户');
        }

        // 2. 提供接口供外部检查手机号
        $ret = $this->event->until('userCheckMobile', [$this, $mobile]);
        if ($ret) {
            return $ret;
        }

        return suc('手机号码可以绑定');
    }

    /**
     * Record: 绑定手机
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @svc
     */
    protected function bindMobile($data)
    {
        // 1. 校验数据
        $ret = $this->checkMobile($data['mobile']);
        if (1 !== $ret['code']) {
            return $ret;
        }

        // 2. 校验验证码
        $ret = wei()->verifyCode->check($data['mobile'], $data['verifyCode']);
        if (1 !== $ret['code']) {
            return $ret + ['verifyCodeErr' => true];
        }

        // 3. 记录手机信息
        $this['mobile'] = $data['mobile'];
        $this->setMobileVerified();

        $this->event->trigger('preUserMobileVerify', [$data, $this]);

        $this->save();

        return $this->suc('绑定成功');
    }

    /**
     * Record: 更新当前用户资料
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @svc
     */
    protected function updateData($data)
    {
        $isMobileVerified = $this->isMobileVerified();

        $validator = wei()->validate([
            'data' => $data,
            'rules' => [
                'mobile' => [
                    'required' => !$isMobileVerified,
                    'mobileCn' => true,
                ],
                'name' => [
                    'required' => false,
                ],
                'address' => [
                    'required' => false,
                    'minLength' => 3,
                ],
            ],
            'names' => [
                'mobile' => '手机号码',
                'name' => '姓名',
                'address' => '详细地址',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        if (!$isMobileVerified) {
            // 手机号未认证时,检查手机号,根据配置检查是否重复
            if (wei()->user->checkMobileUnique && $this->isMobileExists($data['mobile'])) {
                return $this->err('手机号码已存在');
            }
            $this['mobile'] = $data['mobile'];
        }

        $result = $this->event->until('preUserUpdate', [$data, $this]);
        if ($result) {
            return $result;
        }

        $this->save([
            'name' => $data['name'],
            'address' => $data['address'],
        ]);

        return $this->suc();
    }
}
