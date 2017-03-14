<?php

namespace Miaoxing\User\Controller\Admin;

class Group extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '用户分组管理';

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
                $groups->desc('sort')->desc('id');

                $data = $groups->findAll()->toArray();

                return $this->json('读取列表成功', 1, [
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $groups->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $group = wei()->group()->findOrInitById($req['id']);

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction($req)
    {
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'name' => [],
            ],
            'names' => [
                'name' => '名称',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
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
}
