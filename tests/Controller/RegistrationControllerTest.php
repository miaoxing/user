<?php

namespace MiaoxingTest\User\Controller;

use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseControllerTestCase;
use Miaoxing\User\Mailer\Register;

/**
 * 注册
 *
 * @internal
 */
final class RegistrationControllerTest extends BaseControllerTestCase
{
    protected $statusCodes = [
        'register' => 302,
        'create' => 302,
        'editEmail' => 302,
        'resendEmail' => 302,
        'updateEmail' => 302,
        'forget' => 302,
        'createResetByEmail' => 302,
        'reset' => 302,
        'resetUpdate' => 302,
    ];

    protected function setUp(): void
    {
        $this->markTestSkipped('待升级');
    }

    /**
     * 测试未认证用户更新邮箱
     */
    public function testUnValidUserUpdateEmail()
    {
        $this->step('创建未验证的用户');
        $user = wei()->user()->save([
            'email' => 'test@test.com',
            'isValid' => 0,
        ]);

        $this->step('登录用户');
        User::loginByModel($user);

        $this->step('访问修改邮箱页面');
        $res = wei()->tester()
            ->controller('registration')
            ->action('editEmail')
            ->exec()
            ->response();

        $this->step('看到修改邮箱功能');
        $this->assertContains('修改邮箱', $res);

        $this->step('预期修改邮箱会发送新邮件');
        $mail = $this->getServiceMock('mail');
        $mail->expects($this->once())
            ->method('send')
            ->with(Register::class, [
                'user' => User::cur(),
            ])
            ->willReturn([
                'code' => 1,
                'message' => '发送成功',
            ]);

        $this->step('提交新的邮箱');
        wei()->user()->delete(['email' => 'test2@test.com']);
        $ret = wei()->tester()
            ->controller('registration')
            ->action('updateEmail')
            ->req([
                'email' => 'test2@test.com',
            ])
            ->json()
            ->exec()
            ->response();
        $this->assertRetSuc($ret);

        $this->step('用户的邮箱更新了');
        $user->reload();
        $this->assertEquals('test2@test.com', $user['email']);
    }

    /**
     * 测试未认证用户更新邮箱
     */
    public function testUnValidUserResendEmail()
    {
        $this->step('创建未验证的用户');
        $user = wei()->user()->save([
            'email' => 'test@test.com',
            'isValid' => 0,
        ]);

        $this->step('登录用户');
        User::loginByModel($user);

        $this->step('预期会发送新邮件');
        $mail = $this->getServiceMock('mail');
        $mail->expects($this->once())
            ->method('send')
            ->with(Register::class, [
                'user' => User::cur(),
            ])
            ->willReturn([
                'code' => 1,
                'message' => '发送成功',
            ]);

        $this->step('访问重新发送页面');
        $ret = wei()->tester()
            ->controller('registration')
            ->action('resendEmail')
            ->json()
            ->exec()
            ->response();
        $this->assertRetSuc($ret);
    }

    /**
     * 认证用户不能访问修改邮箱页面
     */
    public function testValidUserCantViewEditEmailPage()
    {
        $this->step('创建已验证的用户');
        $user = wei()->user()->save([
            'email' => 'test@test.com',
            'isValid' => 1,
        ]);

        $this->step('登录用户');
        User::loginByModel($user);

        $this->step('访问修改邮箱页面');
        $res = wei()->tester()
            ->controller('registration')
            ->action('editEmail')
            ->exec()
            ->response();

        $this->step('跳转到后台');
        $this->assertContains('Redirecting to /admin', $res);
        $this->assertEquals(302, wei()->res->getStatusCode());

        $this->step('访问修改邮箱后台');
        $res = wei()->tester()
            ->controller('registration')
            ->action('updateEmail')
            ->exec()
            ->response();

        $this->step('跳转到后台');
        $this->assertContains('Redirecting to /admin', $res);
        $this->assertEquals(302, wei()->res->getStatusCode());
    }

    /**
     * 认证用户不能重发邮件
     */
    public function testValidUserCantResendEmail()
    {
        $this->step('创建已验证的用户');
        $user = wei()->user()->save([
            'email' => 'test@test.com',
            'isValid' => 1,
        ]);

        $this->step('登录用户');
        User::loginByModel($user);

        $this->step('访问重发邮件后台');
        $res = wei()->tester()
            ->controller('registration')
            ->action('resendEmail')
            ->exec()
            ->response();

        $this->step('跳转到后台');
        $this->assertContains('Redirecting to /admin', $res);
        $this->assertEquals(302, wei()->res->getStatusCode());
    }
}
