<?php

namespace Miaoxing\User\Controller\AdminApi;

use Miaoxing\Plugin\Service\Ret;
use Miaoxing\Plugin\RetException;
use Miaoxing\Plugin\Service\Plugin;
use Miaoxing\Services\Service\V;
use Wei\Event;
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
        return suc([
            'hasWechatGroup' => Plugin::isInstalled('wechat-group'),
        ]);
    }

    /**
     * @param $req
     * @return Ret
     * @throws RetException
     */
    public function updateAction($req)
    {
        $ret = V::key('name', '名称')->check($req);
        $this->tie($ret);

        $group = GroupModel::findOrInit($req['id'])->fromArray($req);

        $ret = Event::until('groupUpdate', [$group]);
        $this->tie($ret);

        $group->save($req);

        return suc();
    }

    public function destroyAction($req)
    {
        $group = GroupModel::findOrFail($req['id']);

        $ret = Event::until('groupDestroy', [$group]);
        if ($ret) {
            return $ret;
        }

        // 本地删除
        $group->destroy();
        UserModel::where('groupId', $req['id'])->update('groupId', 0);

        return suc();
    }
}
