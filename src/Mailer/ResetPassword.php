<?php

namespace Miaoxing\User\Mailer;

/**
 * @property \Miaoxing\Plugin\Service\User $user
 */
class ResetPassword extends \Miaoxing\Mail\Base
{
    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        $this->Subject = '重置密码';

        $this->addAddress($this->user['email']);

        $nonce = $this->generateNonceStr();
        $timestamp = time();
        $userId = $this->user['id'];
        $password = $this->user['password'];
        $sign = md5($userId . $password . $timestamp . $nonce);
        $resetUrl = $this->url->full('password/reset-return?', [
            'nonce' => $nonce,
            'timestamp' => $timestamp,
            'userId' => $userId,
            'sign' => $sign,
        ]);

        $this->Body = $this->view->render('user:mailers/resetPassword.php', get_defined_vars());
    }
}
