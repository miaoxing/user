<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Services\Middleware\BaseMiddleware;

/**
 * @mixin \UserMixin
 */
class CheckNotVerified extends BaseMiddleware
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if ($this->user->isLogin() && $this->user->cur()->isSubscribed) {
            return $this->res->redirect(wei()->url('admin'));
        }

        return $next();
    }
}
