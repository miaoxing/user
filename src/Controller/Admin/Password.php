<?php

namespace Miaoxing\User\Controller\Admin;

use miaoxing\plugin\BaseController;

class Password extends BaseController
{
    protected $controllerName = '密码管理';

    protected $actionPermissions = [
        'index,update' => '修改密码'
    ];

    public function indexAction($req)
    {
        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $ret = $this->curUser->updatePassword($req);

        return $ret;
    }
}
