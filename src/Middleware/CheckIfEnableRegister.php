<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Plugin\Middleware\Base;
use Wei\RetTrait;

class CheckIfEnableRegister extends Base
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
