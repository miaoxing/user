<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Services\Middleware\BaseMiddleware;

class CheckVerified extends BaseMiddleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if (wei()->curUser->isLogin() && !wei()->curUser['isValid']) {
            return $this->response->redirect(wei()->url('registration/confirm'));
        }

        return $next();
    }
}
