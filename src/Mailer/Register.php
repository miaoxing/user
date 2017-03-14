<?php

namespace Miaoxing\User\Mailer;

/**
 * @property \Miaoxing\Plugin\Service\User $user
 */
class Register extends \Miaoxing\Mail\Base
{
    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        // @codingStandardsIgnoreStart
        $this->Subject = '注册确认';

        $this->addAddress($this->user['email']);

        $verifyUrl = $this->url->full('registration/verify', wei()->userVerify->generate($this->user));

        $this->Body = $this->view->render('user:mailers/register.php', get_defined_vars());
        // @codingStandardsIgnoreEnd
    }
}
