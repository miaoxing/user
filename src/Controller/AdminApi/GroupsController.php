<?php

namespace Miaoxing\User\Controller\AdminApi;

use Miaoxing\Plugin\Service\UserModel;
use Miaoxing\Services\Crud\CrudTrait;
use Miaoxing\Plugin\BaseController;
use Miaoxing\User\Service\GroupModel;

class GroupsController extends BaseController
{
    use CrudTrait;

    protected $controllerName = '分组管理';

    protected $controllerPermissionName = '用户分组管理';

    protected $actionPermissions = [
        'index,metadata' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    public function metadataAction()
    {
        return $this->suc([
            'hasWechatGroup' => $this->plugin->isInstalled('wechat-group'),
        ]);
    }

    public function updateAction($req)
    {
        $ret = wei()->v()
            ->key('name', '名称')
            ->check($req);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        $group = GroupModel::findOrInit($req['id'])->fromArray($req);

        $ret = wei()->event->until('groupUpdate', [$group]);
        if ($ret) {
            return $ret;
        }

        $group->save($req);

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $group = GroupModel::findOrFail($req['id']);

        $ret = wei()->event->until('groupDestroy', [$group]);
        if ($ret) {
            return $ret;
        }

        // 本地删除
        $group->destroy();
        UserModel::where('group_id', $req['id'])->update('group_id = 0');

        return $this->suc();
    }
}
