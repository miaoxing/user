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

    public function testPatch()
    {
        UserModel::findAllBy('mobile', '13800138001')->destroy();

        $user = UserModel::save([
            'name' => '测试',
            'mobile' => '13800138000',
        ]);
        $this->assertNull($user->mobileVerifiedAt);

        $ret = Tester::patchAdminApi('users/' . $user->id, [
            'name' => '测试2',
            'mobile' => '13800138001',
            'isMobileVerified' => true,
        ]);
        $this->assertRetSuc($ret);

        $user->reload();
        $this->assertSame('测试2', $user->name);
        $this->assertSame('13800138001', $user->mobile);
        $this->assertNotEmpty($user->mobileVerifiedAt);
    }

    public function testPatchInvalidMobile()
    {
        $user = UserModel::save([
            'name' => '测试',
            'mobile' => '13800138000',
        ]);

        $ret = Tester::patchAdminApi('users/' . $user->id, [
            'mobile' => '123',
        ]);
        $this->assertRetErr($ret, '手机必须是11位数字,以13到19开头');
    }

    public function testPatchMobileExists()
    {
        UserModel::findAllBy('mobile', '13800138001')->destroy();

        UserModel::new()->setMobileVerified()->save([
            'name' => '测试',
            'mobile' => '13800138001',
        ]);

        $user2 = UserModel::save();

        $ret = Tester::patchAdminApi('users/' . $user2->id, [
            'mobile' => '13800138001',
            'isMobileVerified' => true,
        ]);
        $this->assertRetErr($ret, '已存在认证该手机号码的用户');
    }

    public function testPatchCancelMobileVerify()
    {
        UserModel::findAllBy('mobile', '13800138001')->destroy();

        $user = UserModel::new()->setMobileVerified()->save([
            'name' => '测试',
            'mobile' => '13800138001',
        ]);

        $ret = Tester::patchAdminApi('users/' . $user->id, [
            'isMobileVerified' => false,
        ]);
        $this->assertRetSuc($ret);

        $user->reload();
        $this->assertSame('13800138001', $user->mobile);
        $this->assertFalse($user->isMobileVerified);
    }
}
