<?php

namespace MiaoxingTest\User\Pages\AdminApi\Users;

use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;
use Miaoxing\User\Service\UserModel;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        User::loginById(1);

        $user = UserModel::save([
            'name' => '测试' . time(),
        ]);

        $ret = Tester::request(['id' => $user->id])->getAdminApi('users');

        $this->assertSame($user->name, $ret['data'][0]['name']);
    }
}
