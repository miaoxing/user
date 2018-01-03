<?php

namespace Miaoxing\User\Service;

use miaoxing\plugin\BaseService;
use Miaoxing\User\Mailer\ResetPassword;

class UserPassword extends BaseService
{
    public function createResetByEmail($req)
    {
        // Step1 校验
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'email' => [
                    'required' => true,
                    'email' => true,
                ],
            ],
            'names' => [
                'email' => '邮箱',
            ],
            'messages' => [
                'email' => [
                    'required' => '请输入邮箱',
                    'email' => '请输入正确的邮箱格式',
                ],
            ],
        ]);
        if (!$validator->isValid()) {
            return ['code' => -1, 'message' => $validator->getFirstMessage()];
        }

        // Step2 查找是否存在该用户
        $user = wei()->user()->find(['email' => $req['email']]);
        if (!$user) {
            return ['code' => -1, 'message' => '不存在该用户'];
        }

        // Step3 邮箱发送验证码
        $ret = wei()->mail->send(ResetPassword::class, [
            'user' => $user,
        ]);

        return $ret;
    }

    public function resetPassword($req)
    {
        $ret = wei()->userVerify->verify($req, false);
        if ($ret['code'] < 0) {
            return ['code' => -1, 'message' => $ret['message']];
        }

        // 1. 校验
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'password' => [
                    'minLength' => 6,
                ],
                'passwordConfirm' => [
                    'equalTo' => $req['password'],
                ],
            ],
            'names' => [
                'password' => '新密码',
                'passwordConfirm' => '重复密码',
            ],
            'messages' => [
                'passwordConfirm' => [
                    'equalTo' => '两次输入的密码不相等',
                ],
            ],
        ]);
        if (!$validator->isValid()) {
            return ['code' => -1, 'message' => $validator->getFirstMessage()];
        }

        // Step2 更新新密码
        $user = wei()->user()->findById($req['userId']);
        $user->setPlainPassword($req['password']);
        $user->save();

        return ['code' => 1, 'message' => '操作成功'];
    }
}
