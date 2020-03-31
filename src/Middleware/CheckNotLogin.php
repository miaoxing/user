<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Services\Middleware\BaseMiddleware;
use Wei\RetTrait;

/**
 * 如果用户已登录,跳转到指定地址
 *
 * @mixin \UserMixin
 */
class CheckNotLogin extends BaseMiddleware
{
    use RetTrait;

    protected $redirect = 'users';

    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if (!$this->user->isLogin()) {
            return $next();
        }

        if ($this->request->isAjax()) {
            return $this->err('您已经登录,不能访问该页面');
        } else {
            return $this->response->redirect(wei()->url($this->redirect));
        }
    }
}
