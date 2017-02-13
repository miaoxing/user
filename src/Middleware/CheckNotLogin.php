<?php

namespace Miaoxing\User\Middleware;

use Miaoxing\Plugin\Middleware\Base;
use Wei\RetTrait;

/**
 * 如果用户已登录,跳转到指定地址
 */
class CheckNotLogin extends Base
{
    use RetTrait;

    protected $redirect = 'users';

    /**
     * {@inheritdoc}
     */
    public function __invoke($next)
    {
        if (!wei()->curUser->isLogin()) {
            return $next();
        }

        if ($this->request->isAjax()) {
            return $this->err('您已经登录,不能访问该页面');
        } else {
            return $this->response->redirect(wei()->url($this->redirect));
        }
    }
}
