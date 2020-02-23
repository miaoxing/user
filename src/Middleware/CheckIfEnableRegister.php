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
        if (!wei()->user->enableRegister) {
            return $this->err(wei()->user->disableRegisterTips);
        }

        return $next();
    }
}
