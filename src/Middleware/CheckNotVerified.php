<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Plugin\Middleware\Base;

class CheckNotVerified extends Base
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if (wei()->curUser->isLogin() && wei()->curUser['isValid']) {
            return $this->response->redirect(wei()->url('admin'));
        }

        return $next();
    }
}
