<?php

namespace Miaoxing\User;

use Miaoxing\Admin\Service\AdminMenu;
use Miaoxing\Plugin\Service\User;

class UserPlugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = '用户';

    protected $description = '';

    protected $code = 204;

    protected $adminNavId = 'user';

    public function onAdminMenuGetMenus(AdminMenu $menu)
    {
        $user = $menu->child('user');

        $user->addChild()->setLabel('用户管理')->setUrl('admin/users')->setSort(1000);
        $user->addChild()->setLabel('分组管理')->setUrl('admin/groups');
    }

    public function onLinkToGetLinks(&$links, &$types)
    {
        $types['user'] = [
            'name' => '用户',
            'sort' => 600,
        ];

        $links[] = [
            'typeId' => 'user',
            'name' => '个人中心',
            'url' => 'user',
        ];

        $links[] = [
            'typeId' => 'user',
            'name' => '个人信息',
            'url' => 'user/edit',
        ];
    }

    public function onNavGetTypes(&$types)
    {
        $types['user'] = [
            'name' => '个人中心',
            'supports' => [
                'type',
                'icons',
                'bg-color',
            ],
        ];
    }

    /**
     * 创建用户后,将用户移到默认分组
     *
     * @param User $user
     */
    public function onAsyncUserCreate(User $user)
    {
        if ($user['groupId']) {
            return;
        }

        $defaultGroupId = wei()->user->defaultGroupId;
        if ($defaultGroupId) {
            $user->updateGroup($defaultGroupId);
        }
    }
}
