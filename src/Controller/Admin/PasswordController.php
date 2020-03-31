<?php

namespace Miaoxing\User\Controller\Admin;

use Miaoxing\Plugin\BaseController;
use Miaoxing\Plugin\Service\User;

class PasswordController extends BaseController
{
    protected $controllerName = '密码管理';

    protected $actionPermissions = [
        'index,update' => '修改密码',
    ];

    public function indexAction($req)
    {
        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $ret = User::updatePassword($req);

        return $ret;
    }
}
