<?php

namespace MiaoxingTest\User\Service;

class UserModelTest extends \Miaoxing\Plugin\Test\BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        wei()->user()->delete();
        wei()->user()
            ->setPlainPassword('admin')
            ->save([
                'id' => 1,
                'username' => 'miaostar',
                'email' => '790449591@qq.com',
                'mobile' => '15989130451',
                'admin' => true,
            ]);

        // 创建未启用的用户
        wei()->user()->save([
            'id' => 2,
            'username' => 'admin-not-enable',
            'enable' => false,
        ]);
    }

    public function testStatus()
    {
        $user = wei()->user();

        $user->setStatus(1, true);
        $user->setStatus(2, false);
        $user->setStatus(3, true);
        $user->setStatus(4, false);
        $user->save();

        $user->reload();
        $this->assertTrue($user->isStatus(1));
        $this->assertFalse($user->isStatus(2));
        $this->assertTrue($user->isStatus(3));
        $this->assertFalse($user->isStatus(4));
    }

    public function testUpdateGroup()
    {
        $user = wei()->user();
        $user->updateGroup(1);

        $this->assertEquals(1, $user['groupId']);
    }
}
