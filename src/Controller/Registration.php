<?php

namespace Miaoxing\User\Controller;

use miaoxing\plugin\BaseController;
use Miaoxing\User\Mailer\Register;
use Miaoxing\User\Middleware\CheckNotLogin;
use Miaoxing\User\Middleware\CheckNotVerified;
use Miaoxing\User\Middleware\CheckVerified;

class Registration extends BaseController
{
    protected $guestPages = [
        'registration/register',
        'registration/create',
        'registration/verify',
    ];

    public function __construct(array $options)
    {
        parent::__construct($options);

        $this->middleware(CheckNotLogin::className(), [
            'only' => ['register', 'create'],
            'redirect' => 'admin',
        ]);

        $this->middleware(CheckVerified::className(), [
            'except' => [
                'editEmail',
                'updateEmail',
                'resendEmail',
                'confirm',
                'verify',
            ],
        ]);

        $this->middleware(CheckNotVerified::className(), [
            'only' => [
                'editEmail',
                'updateEmail',
                'resendEmail',
            ]
        ]);
    }

    public function registerAction($req)
    {
        $agreementArticleId = $this->setting('user.agreementArticleId');

        return get_defined_vars();
    }

    public function createAction($req)
    {
        // 1. 增加注册的校验
        $this->event->on('userRegisterValidate', function () use ($req) {
            $ret = wei()->captcha->check($req['captcha']);
            if ($ret['code'] !== 1) {
                $ret['captchaErr'] = true;

                return $ret;
            }

            if ($this->setting('user.agreementArticleId') && !$req['agreement']) {
                return $this->err('请同意《服务协议》');
            }
        });

        // 2. 调用注册接口
        $user = wei()->user();
        $ret = $user->register($req);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        // 3. 设置用户角色为管理员
        $user->save([
            'admin' => true,
            'isValid' => false, // 待验证邮箱
        ]);

        wei()->event->trigger('postAdminRegister', [$user]);

        // 4. 登录用户
        $loginRet = wei()->curUser->loginById($user['id']);
        if ($loginRet['code'] !== 1) {
            return $loginRet;
        }

        // 5. 发送确认邮件
        $sendRet = wei()->mail->send(Register::className(), [
            'user' => $user,
        ]);
        if ($sendRet['code'] !== 1) {
            return $sendRet;
        }

        return $ret;
    }

    public function confirmAction($req)
    {
        return get_defined_vars();
    }

    public function verifyAction($req)
    {
        $ret = wei()->userVerify->verify($req);
        if ($ret['code'] !== 1) {
            return $ret;
        }

        $user = $ret['user'];
        $user->save(['isValid' => true]);

        return get_defined_vars();
    }

    public function resendEmailAction()
    {
        $ret = wei()->mail->send(Register::className(), [
            'user' => $this->curUser,
        ]);

        return $ret;
    }

    public function editEmailAction()
    {
        return get_defined_vars();
    }

    public function updateEmailAction($req)
    {
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'email' => [
                    'email' => true,
                    'notEqualTo' => $this->curUser['email'],
                    'notRecordExists' => ['user', 'email'],
                ],
            ],
            'names' => [
                'email' => '新邮箱',
            ],
            'messages' => [
                'email' => [
                    'notEqualTo' => '新邮箱不能和原邮箱相同',
                ],
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        $this->curUser->save([
            'email' => $req['email'],
        ]);

        $ret = wei()->mail->send(Register::className(), [
            'user' => $this->curUser,
        ]);

        return $ret;
    }
}
