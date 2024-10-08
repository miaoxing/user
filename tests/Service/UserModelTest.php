<?php

namespace MiaoxingTest\User\Service;

use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Service\UserModel;

/**
 * @internal
 */
final class UserModelTest extends \Miaoxing\Plugin\Test\BaseTestCase
{
    /**
     * 测试获取昵称
     */
    public function testDisplayName()
    {
        $user = UserModel::new();
        $this->assertEquals('', $user->displayName);

        $this->assertEquals('', $user->displayName);

        $user['name'] = 'name';
        $this->assertEquals('name', $user->displayName);

        $user['username'] = 'username';
        $this->assertEquals('username', $user->displayName);

        $user['nickName'] = 'nickName';
        $this->assertEquals('nickName', $user->displayName);
    }

    public function testIsAdmin()
    {
        $user = UserModel::new();
        $this->assertFalse($user->isAdmin);

        $user->isAdmin = true;
        $this->assertTrue($user->isAdmin);
    }

    public function testUpdateGroup()
    {
        $user = UserModel::new();

        $ret = $user->updateGroup(1);
        $this->assertRetSuc($ret);

        $this->assertEquals(1, $user->groupId);
    }

    public function testAvatar()
    {
        $userService = User::instance();

        $user = UserModel::new();
        $this->assertEquals($userService->defaultAvatar, $user->avatar);

        $user->avatar = 'test.jpg';
        $this->assertEquals('test.jpg', $user->avatar);

        $user->avatar = '';
        $this->assertEquals($userService->defaultAvatar, $user->avatar);
    }

    /**
     * 检查手机号码能否绑定
     */
    public function testCheckMobile()
    {
        $mobile = '12800138000';
        UserModel::delete('mobile', $mobile);

        $testUser = UserModel::new();
        $ret = $testUser->checkMobile($mobile);
        $this->assertRetSuc($ret, '手机号码可以绑定', '未存在指定手机号码的用户,可以绑定');

        $user = UserModel::save(['mobile' => $mobile]);
        $ret = $testUser->checkMobile($mobile);
        $this->assertRetSuc($ret, '手机号码可以绑定');

        $user->setMobileVerified()->save();
        $ret = $testUser->checkMobile($mobile);
        $this->assertRetErr($ret, '已存在认证该手机号码的用户', -1);
    }

    public function testToArrayHasVirtualColumn()
    {
        $user = UserModel::toArray();

        $this->assertArrayHasKey('isMobileVerified', $user);
    }
}
