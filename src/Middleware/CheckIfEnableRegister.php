<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Services\Middleware\BaseMiddleware;
use Wei\RetTrait;

class CheckIfEnableRegister extends BaseMiddleware
{
    use RetTrait;

    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if (!wei()->setting('user.enableRegister', true)) {
            return $this->err(wei()->setting('user.disableRegisterTips', '注册功能未启用'));
        }

        return $next();
    }
}
