<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Services\Middleware\BaseMiddleware;

/**
 * @mixin \UserMixin
 */
class CheckVerified extends BaseMiddleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if ($this->user->isLogin() && !$this->user->cur()->isSubscribed) {
            return $this->response->redirect(wei()->url('registration/confirm'));
        }

        return $next();
    }
}
