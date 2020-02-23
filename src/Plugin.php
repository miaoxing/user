<?php

namespace Miaoxing\User;

use Miaoxing\Plugin\Service\User;

class Plugin extends \Miaoxing\Plugin\BasePlugin
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

        $subCategories[] = [
            'parentId' => 'user',
            'url' => 'admin/user',
            'name' => '用户管理',
            'sort' => 1000,
        ];

        if (wei()->plugin->isInstalled('user-tag')) {
            $subCategories[] = [
                'parentId' => 'user',
                'url' => 'admin/user-tags',
                'name' => '标签管理',
            ];
        } else {
            $subCategories[] = [
                'parentId' => 'user',
                'url' => 'admin/groups',
                'name' => '分组管理',
            ];
        }
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
