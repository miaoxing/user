<?php

namespace Miaoxing\User\Controller\Admin;

use Miaoxing\Admin\Action\NewCreateTrait;
use Miaoxing\Admin\Action\ShowTrait;
use Miaoxing\Admin\Bs4Layout;
use Miaoxing\Plugin\Service\Request;
use Miaoxing\User\Service\GroupModel;

class Groups extends \Miaoxing\Plugin\BaseController
{
    use NewCreateTrait;
    use ShowTrait;
    use Bs4Layout;

    protected $controllerName = '分组管理';

    protected $controllerPermissionName = '用户分组管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $groups = wei()->group();

                // 分页
                $groups->limit($req['rows'])->page($req['page']);

                // 排序
                $groups->setRequest($req)
                    ->sort();

                $data = $groups->findAll()->toArray();

                return $this->suc([
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $groups->count(),
                ]);

            default:
                $this->js['hasWechatGroup'] = $this->plugin->isInstalled('wechat-group');
                return get_defined_vars();
        }
    }

    public function editAction($req)
    {
        $group = wei()->group()->findOrInitById($req['id']);

        $this->js['group'] = $group;

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $ret = wei()->v()
            ->key('name', '名称')
            ->check($req);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        $group = wei()->group()->findOrInitById($req['id']);
        $group['name'] = $req['name'];
        if ($req['sort']) {
            $group['sort'] = $req['sort'];
        }

        $ret = wei()->event->until('groupUpdate', [$group]);
        if ($ret) {
            return $this->ret($ret);
        }

        $group->save($req);

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $group = wei()->group()->findOneById($req['id']);
        $ret = wei()->event->until('groupDestroy', [$group]);
        if ($ret) {
            return $this->ret($ret);
        }

        // 本地删除
        wei()->group()->destroy($req['id']);
        wei()->user()->where(['groupId' => $req['id']])->update('groupId = 0');

        return $this->suc();
    }

    protected function beforeShowFind(Request $req, GroupModel $model)
    {
    }

    protected function buildShowData(GroupModel $model)
    {
        return [];
    }
}
