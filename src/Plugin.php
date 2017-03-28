<?php

namespace Miaoxing\User;

class Plugin extends \miaoxing\plugin\BasePlugin
{
    protected $name = '用户';

    protected $description = '';

    protected $adminNavId = 'user';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $categories['user'] = [
            'name' => '用户',
            'sort' => 600,
        ];

        $subCategories['user'] = [
            'parentId' => 'user',
            'name' => '用户',
            'icon' => 'fa fa-user'
        ];

        $navs[] = [
            'parentId' => 'user',
            'url' => 'admin/user/index',
            'name' => '用户管理',
            'sort' => 1000,
        ];

        $navs[] = [
            'parentId' => 'user',
            'url' => 'admin/group/index',
            'name' => '分组管理',
        ];

        $navs[] = [
            'parentId' => 'user',
            'url' => 'admin/user/ref',
            'name' => '来源统计',
        ];

        $subCategories['user-setting'] = [
            'parentId' => 'user',
            'name' => '设置',
            'icon' => 'fa fa-gear',
            'sort' => 0,
        ];

        $navs[] = [
            'parentId' => 'user-setting',
            'url' => 'admin/user-settings',
            'name' => '功能设置',
        ];
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
            'url' => 'users/index'
        ];

        $links[] = [
            'typeId' => 'user',
            'name' => '个人信息',
            'url' => 'users/info'
        ];
    }

    public function onNavGetTypes(&$types)
    {
        $types['user'] = [
            'name' => '个人中心',
            'supports' => [
                'type',
                'icons',
                'bg-color'
            ]
        ];
    }
}
