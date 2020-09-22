<?php

return [
    '/admin' => [
        '/users' => [
            'name' => '用户管理',
            'apis' => [
                [
                    'method' => 'GET',
                    'page' => 'admin-api/users',
                ],
            ],

            '/[id]' => [
                '/edit' => [
                    'name' => '编辑',
                    'apis' => [
                        [
                            'method' => 'GET',
                            'page' => 'admin-api/users/[id]',
                        ],
                        [
                            'method' => 'PATCH',
                            'page' => 'admin-api/users/[id]',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
