<?php

namespace MiaoxingTest\User\Pages\AdminApi\Users;

use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;
use Miaoxing\User\Service\UserModel;

class IdTest extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        User::loginById(1);
    }

    public static function tearDownAfterClass(): void
    {
        User::logout();

        parent::tearDownAfterClass();
    }

    public function testGet()
    {
        $user = UserModel::save([
            'name' => '测试',
        ]);

        $ret = Tester::getAdminApi('users/' . $user->id);
        $this->assertRetSuc($ret);
        $this->assertSame('测试', $ret['data']['name']);
    }
}
