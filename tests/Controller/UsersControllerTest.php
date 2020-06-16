<?php

namespace MiaoxingTest\User\Controller;

use Miaoxing\Plugin\Service\User;

/**
 * @internal
 */
final class UsersControllerTest extends \Miaoxing\Plugin\Test\BaseControllerTestCase
{
    protected $statusCodes = [
        'logout' => 302,
        'register' => 302,
        'create' => 302,
    ];

    public static function setupBeforeClass(): void
    {
        // 创建用户供测试用户名和邮箱已存在
        $user = wei()->userModel()
            ->findOrInitBy(['username' => 'test'])
            ->setPlainPassword('123456')
            ->save([
                'email' => 'test@test.com',
            ]);

        // 删除已存在的用户供注册
        wei()->userModel()->where(['email' => 'test2@test.com'])->destroy();
    }

    protected function setUp(): void
    {
        $this->markTestSkipped('待升级');
    }

    public function providerForRegisterByEmail()
    {
        return [
            [
                [
                    // 输入空数据
                ],
                [
                    'code' => -1,
                    'message' => '请输入邮箱',
                ],
            ],
            [
                [
                    // 输入不合法邮箱
                    'email' => 'test',
                ],
                [
                    'code' => -7,
                    'message' => '邮箱必须是有效的邮箱地址',
                ],
            ],
            [
                [
                    // 输入已存在邮箱
                    'email' => 'test@test.com',
                ],
                [
                    'code' => -7,
                    'message' => '邮箱已存在',
                ],
            ],
            [
                [
                    'email' => 'test@example.com',
                    // 未输入密码
                ],
                [
                    'code' => -7,
                    'message' => '密码不能为空',
                ],
            ],
            [
                [
                    'email' => 'test@example.com',
                    'password' => '123456',
                    // 未确认密码不相等密码
                    'passwordConfirm' => 'abcdef',
                ],
                [
                    'code' => -7,
                    'message' => '两次输入的密码不相等',
                ],
            ],
            [
                [
                    'email' => 'test2@test.com',
                    'username' => 'test2',
                    'password' => '123456',
                    // 未确认密码不相等密码
                    'passwordConfirm' => '123456',
                ],
                [
                    'code' => 1,
                    'message' => '注册成功',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForRegisterByEmail
     * @param mixed $req
     * @param mixed $ret
     */
    public function testRegisterByEmail($req, $ret)
    {
        User::logout();

        $actualRet = wei()->tester()
            ->controller('users')
            ->action('create')
            ->request($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);

        if (1 === $ret['code']) {
            // 用户注册成功后,数据表有相应的数据
            $user = wei()->user()->find(['username' => 'test2']);
            $this->assertNotNull($user);
            $this->assertEquals('test2@test.com', $user['email']);
            $this->assertTrue(wei()->password->verify('123456', $user['password']));
        }
    }

    public function providerForRegisterByMobile()
    {
        return [
            [
                [
                    'username' => 'miaomiao',
                    'mobile' => '15989130452',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -1,
                    'message' => '请输入验证码',
                ],
            ], [
                [
                    'username' => 'miaomiao',
                    'mobile' => '15989130452',
                    'verifyCode' => '123456',
                    'password' => 'adminad',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => -7,
                    'message' => '两次输入的密码不相等',
                ],
            ], [
                [
                    'username' => 'miaomiao',
                    'mobile' => '15989130452',
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
                    'username' => 'miaomiao',
                    'mobile' => '15989130452',
                    'verifyCode' => '123456',
                    'password' => 'admina',
                    'passwordConfirm' => 'admina',
                ], [
                    'code' => 1,
                    'message' => '注册成功',
                ],
            ],
        ];
    }

    /**
     * 注册页(手机注册)
     *
     * @dataProvider providerForRegisterByMobile
     * @param mixed $req
     * @param mixed $ret
     */
    public function testRegisterByMobile($req, $ret)
    {
        User::logout();

        wei()->verifyCode->session['verifyCode'] = [
            'code' => '123456',
            'mobile' => $req['mobile'],
            'canSendTime' => 60,
        ];

        $actualRet = wei()->tester()
            ->controller('users')
            ->action('create')
            ->method('post')
            ->request($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);

        if (1 === $ret['code']) {
            // 用户注册成功后,数据表有相应的数据
            /** @var User $user */
            $user = wei()->user()->find(['username' => 'miaomiao']);
            $this->assertNotNull($user);
            $this->assertEquals('15989130452', $user['mobile']);
            $this->assertTrue(wei()->password->verify('admina', $user['password']));
            $this->assertTrue($user->isMobileVerified());
        }
    }

    public function providerForNotLoginPages()
    {
        return [
            ['register'],
            ['create'],
        ];
    }

    /**
     * 只有未登录用户,可以访问注册页面
     *
     * @dataProvider providerForNotLoginPages
     * @param mixed $page
     */
    public function testNotLoginPages($page)
    {
        User::loginById(1);
        wei()->response->setStatusCode(200);

        wei()->tester()
            ->controller('users')
            ->action($page)
            ->exec();

        $this->assertEquals(302, wei()->response->getStatusCode());
    }

    public function providerForUserLogin()
    {
        return [
            [
                [
                    'username' => 'not-exists',
                    'password' => '123456',
                ],
                [
                    'code' => -2,
                    'message' => '用户名不存在或密码错误',
                ],
            ],
            [
                [
                    'username' => 'not-exists@test.com',
                    'password' => '123456',
                ],
                [
                    'code' => -2,
                    'message' => '用户名不存在或密码错误',
                ],
            ],
            [
                [
                    'username' => 'test',
                    'password' => 'abcdef',
                ],
                [
                    'code' => -4,
                    'message' => '用户不存在或密码错误',
                ],
            ],
            [
                [
                    'username' => 'test',
                    'password' => '123456',
                ],
                [
                    'code' => 1,
                    'message' => '登录成功',
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForUserLogin
     * @param array $req
     * @param array $ret
     * @throws \Exception
     */
    public function testUserLogin(array $req, array $ret)
    {
        User::logout();

        $actualRet = wei()->tester()
            ->controller('users')
            ->action('login')
            ->method('post')
            ->request($req)
            ->json()
            ->exec()
            ->response();

        $this->assertEquals($ret, $actualRet);

        if (1 == $actualRet['code']) {
            $this->assertNotEmpty(wei()->session['user']['id']);
        }
    }
}
