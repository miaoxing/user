<?php

namespace MiaoxingTest\User\Service;

use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Service\UserModel;

class UserModelTest extends \Miaoxing\Plugin\Test\BaseTestCase
{
    /**
     * 测试获取昵称
     */
    public function testGetNickName()
    {
        $user = UserModel::new();
        $this->assertEquals('', $user->getNickName());

        $this->assertEquals('', $user->getNickName());

        $user['name'] = 'name';
        $this->assertEquals('name', $user->getNickName());

        $user['username'] = 'username';
        $this->assertEquals('username', $user->getNickName());

        $user['nickName'] = 'nickName';
        $this->assertEquals('nickName', $user->getNickName());
    }

    public function testIsAdmin()
    {
        $user = UserModel::new();
        $this->assertFalse($user->isAdmin());

        $user->isAdmin = true;
        $this->assertTrue($user->isAdmin());
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
        $user = UserModel::new();
        $this->assertEquals(User::cur()->defaultAvatar, $user->avatar);

        $user->avatar = 'test.jpg';
        $this->assertEquals('test.jpg', $user->avatar);
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
        $this->assertRetErr($ret, -1, '已存在认证该手机号码的用户');
    }
}
