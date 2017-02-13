<?php

namespace MiaoxingTest\User\Controller;

class PasswordTest extends \Miaoxing\Plugin\Test\BaseControllerTestCase
{
    /**
     * 不管是否可以登陆，都可以访问忘记密码页面
     */
    public function testPagesAnyTime()
    {
        wei()->curUser->loginById(1);
        wei()->tester()
            ->controller('password')
            ->action('reset')
            ->exec()
            ->response();

        $this->assertEquals(200, wei()->response->getStatusCode());

        wei()->curUser->logout();
        wei()->tester()
            ->controller('password')
            ->action('reset')
            ->exec()
            ->response();

        $this->assertEquals(200, wei()->response->getStatusCode());
    }

    public function providerForResetByEmail()
    {
        return [
            [
                [
                    'username' => 'notexists',
                    'email' => 'not-exists@qq.com',
                ], [
                'code' => -1,
                'message' => '用户名不存在',
                ],
            ], [
                [
                    'username' => 'notexists',
                ], [
                    'code' => -1,
                    'message' => '请输入邮箱',
                ],
            ], [
                [
                    'email' => 'notexists@qq.com',
                ], [
                    'code' => -1,
                    'message' => '请输入用户名',
                ],
            ], [
                [
                    'username' => 'no',
                    'email' => 'notexists@qq.com',
                ], [
                    'code' => -1,
                    'message' => '请输入3-30字符以内的用户名',
                ],
            ], [
                [
                    'username' => 'notexists',
                    'email' => 'notexists',
                ], [
                    'code' => -1,
                    'message' => '请输入正确的邮箱格式',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'email' => 'abcdef@qq.com',
                ], [
                    'code' => -1,
                    'message' => '邮箱跟用户名不属于同一个用户',
                ],
            ],
        ];
    }

    /**
     *  测试忘记密码页(邮箱找回)
     * @dataProvider providerForResetByEmail
     */
    public function testResetByEmail($req, $ret)
    {
        wei()->curUser->logout();

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('createResetByEmail')
            ->method('post')
            ->request($req)
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
                ], [
                'code' => -1,
                'message' => '请输入用户名',
                ],
            ], [
                [
                    'username' => 'mi',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '请输入3-30字符以内的用户名',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '请输入手机号码',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '请输入验证码',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'adminad',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '两次输入的密码不相等',
                ],
            ], [
                [
                    'username' => 'miao',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '用户名不存在',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130452',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '手机号码跟用户名不属于同一个用户',
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '1234567',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -2,
                    'message' => '验证码不正确,请重新获取',
                    'verifyCodeErr' => true,
                ],
            ], [
                [
                    'username' => 'miaostar',
                    'mobile' => '15989130451',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => 1,
                    'message' => '操作成功',
                ],
            ],
        ];
    }

    /**
     *  测试忘记密码页(手机找回)
     * @dataProvider providerForResetByMobile
     */
    public function testResetByMobile($req, $ret)
    {
        wei()->curUser->logout();

        wei()->verifyCode->session['verifyCode'] = [
            'code' => '123456',
            'mobile' => $req['mobile'],
            'canSendTime' => 60,
        ];

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('createResetByMobile')
            ->method('post')
            ->request($req)
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
                ], [
                'code' => 1,
                'message' => '发送成功',
                ],
            ],
        ];
    }

    /**
     *  测试发送邮件功能
     * @dataProvider providerForSendMail
     */
    public function testSendMail($req, $ret)
    {
        wei()->curUser->logout();
        $mock = $this->getServiceMock('mailer', ['send']);
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
            ->request($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);
    }

    public function providerForResetReturn()
    {
        wei()->curUser->loginById(1);
        $timestamp = time();
        $userId = wei()->curUser['id'];
        $password = wei()->curUser['password'];
        $nonce = $this->generateNonceStr();
        $sign = md5($userId . $password . $timestamp . $nonce);

        return [
            [
                [
                    'timestamp' => $timestamp - 86420,
                    'userId' => $userId,
                    'nonce' => $nonce,
                    'sign' => $sign,
                ], [
                'code' => -1,
                'message' => '链接超时无效',
                ],
            ], [
                [
                    'timestamp' => $timestamp,
                    'userId' => $userId . '001000100001000001',
                    'nonce' => $nonce,
                    'sign' => $sign,
                ], [
                    'code' => -1,
                    'message' => '用户不存在',
                ],
            ], [
                [
                    'timestamp' => $timestamp,
                    'userId' => $userId,
                    'nonce' => $nonce,
                    'sign' => md5($sign),
                ], [
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
     */
    public function testResetReturn($req, $ret)
    {
        wei()->curUser->logout();

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('resetReturn')
            ->method('post')
            ->request($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);

        $actualRet = wei()->tester()
            ->controller('password')
            ->action('resetUpdate')
            ->method('post')
            ->request($req)
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
