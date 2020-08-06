<?php

namespace MiaoxingTest\User\Controller;

use Miaoxing\Plugin\Service\User;

/**
 * @internal
 */
final class PasswordControllerTest extends \Miaoxing\Plugin\Test\BaseControllerTestCase
{
    public static function setupBeforeClass(): void
    {
        // 创建用户供测试用户名和邮箱已存在
        $user = wei()->user()
            ->findOrInitBy(['username' => 'miaostar'])
            ->setPlainPassword('admina')
            ->save([
                'mobile' => '13800138000',
                'email' => 'test@test.com',
            ]);
    }

    protected function setUp(): void
    {
        $this->markTestSkipped('待升级');
    }

    /**
     * 不管是否可以登陆，都可以访问忘记密码页面
     */
    public function testPagesAnyTime()
    {
        User::loginById(1);
        wei()->tester()
            ->controller('password')
            ->action('reset')
            ->exec()
            ->response();

        $this->assertEquals(200, wei()->res->getStatusCode());

        User::logout();
        wei()->tester()
            ->controller('password')
            ->action('reset')
            ->exec()
            ->response();

        $this->assertEquals(200, wei()->res->getStatusCode());
    }

    public function providerForResetByEmail()
    {
        return [
            [
                [
                    'email' => '',
                ],
                [
                    'code' => -1,
                    'message' => '请输入邮箱',
                ],
            ],
            [
                [
                    'email' => 'notexists',
                ],
                [
                    'code' => -1,
                    'message' => '请输入正确的邮箱格式',
                ],
            ],
        ];
    }

    /**
     *  测试忘记密码页(邮箱找回)
     * @dataProvider providerForResetByEmail
     * @param mixed $req
     * @param mixed $ret
     */
    public function testResetByEmail($req, $ret)
    {
        User::logout();

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('createResetByEmail')
            ->method('post')
            ->req($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);
    }

    public function providerForResetByMobile()
    {
        return [
            [
                [
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '请输入用户名',
                ],
            ],
            [
                [
                    'username' => 'mi',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '请输入3-30字符以内的用户名',
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '请输入手机号码',
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '请输入验证码',
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'adminad',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '两次输入的密码不相等',
                ],
            ],
            [
                [
                    'username' => 'miao',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '用户名不存在',
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130452',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -1,
                    'message' => '手机号码跟用户名不属于同一个用户',
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '1234567',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                [
                    'code' => -2,
                    'message' => '验证码不正确,请重新获取',
                    'verifyCodeErr' => true,
                ],
            ],
            [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ],
                wei()->ret->suc(),
            ],
        ];
    }

    /**
     *  测试忘记密码页(手机找回)
     * @dataProvider providerForResetByMobile
     * @param mixed $req
     * @param mixed $ret
     */
    public function testResetByMobile($req, $ret)
    {
        User::logout();

        wei()->verifyCode->session['verifyCode'] = [
            'code' => '123456',
            'mobile' => $req['mobile'],
            'canSendTime' => 60,
        ];

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('createResetByMobile')
            ->method('post')
            ->req($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);
    }

    public function providerForSendMail()
    {
        return [
            [
                [
                    'username' => 'miaostar',
                    'email' => '790449591@qq.com',
                ],
                [
                    'code' => 1,
                    'message' => '发送成功',
                ],
            ],
        ];
    }

    /**
     *  测试发送邮件功能
     * @dataProvider providerForSendMail
     * @param mixed $req
     * @param mixed $ret
     */
    public function testSendMail($req, $ret)
    {
        User::logout();
        $mock = $this->getServiceMock('mail', ['send']);
        $mock->expects($this->once())
            ->method('send')
            ->willReturn([
                'code' => 1,
                'message' => '发送成功',
            ]);

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('createResetByEmail')
            ->method('post')
            ->req($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);
    }

    public function providerForResetReturn()
    {
        User::loginById(1);
        $timestamp = time();
        $user = User::cur();
        $userId = $user->id;
        $password = $user->password;
        $nonce = $this->generateNonceStr();
        $sign = md5($userId . $password . $timestamp . $nonce);

        return [
            [
                [
                    'timestamp' => $timestamp - 86420,
                    'userId' => $userId,
                    'nonce' => $nonce,
                    'sign' => $sign,
                ],
                [
                    'code' => -1,
                    'message' => '链接超时无效',
                ],
            ],
            [
                [
                    'timestamp' => $timestamp,
                    'userId' => $userId . '001000100001000001',
                    'nonce' => $nonce,
                    'sign' => $sign,
                ],
                [
                    'code' => -1,
                    'message' => '用户不存在',
                ],
            ],
            [
                [
                    'timestamp' => $timestamp,
                    'userId' => $userId,
                    'nonce' => $nonce,
                    'sign' => md5($sign),
                ],
                [
                    'code' => -1,
                    'message' => '链接验证无效',
                ],
            ],
        ];
    }

    /**
     * 测试密码重置页面
     *
     * @dataProvider providerForResetReturn
     * @param mixed $req
     * @param mixed $ret
     */
    public function testResetReturn($req, $ret)
    {
        User::logout();

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('resetReturn')
            ->method('post')
            ->req($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('resetUpdate')
            ->method('post')
            ->req($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);
    }

    public function generateNonceStr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }
}
