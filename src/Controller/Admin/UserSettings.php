<?php

namespace Miaoxing\User\Controller\Admin;

class UserSettings extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '用户设置';

    protected $actionPermissions = [
        'index,update' => '设置',
    ];

    public function indexAction()
    {
        $bgImage = &$this->setting('user.bgImage');
        wei()->event->trigger('postImageLoad', [&$bgImage]);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $settings = (array)$req['settings'];
        wei()->event->trigger('preImageDataSave', [&$settings, ['user.bgImage']]);

        $this->setting->setValues($settings, 'user.');
        return $this->suc();
    }
}
