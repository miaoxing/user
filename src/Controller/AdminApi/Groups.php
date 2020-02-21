<?php

namespace Miaoxing\User\Controller\AdminApi;

use Miaoxing\Crud\CrudTrait;
use Miaoxing\Plugin\BaseController;
use Miaoxing\Plugin\Service\Request;
use Miaoxing\User\Service\GroupModel;

class Groups extends BaseController
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

    protected function beforeIndexFind(Request $req, GroupModel $models)
    {
    }

    protected function afterIndexFind(Request $req, GroupModel $models)
    {
    }

    protected function buildIndexData(GroupModel $model)
    {
        return [];
    }

    protected function buildIndexRet($ret, Request $req, GroupModel $models)
    {
        return $ret;
    }

    protected function beforeShowFind(Request $req, GroupModel $model)
    {
    }

    protected function buildShowData(GroupModel $model)
    {
        return [];
    }
}
