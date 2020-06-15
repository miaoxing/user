<?php

namespace Miaoxing\User\Controller;

use Miaoxing\Plugin\Service\User;
use Miaoxing\Services\Middleware\CheckRedirectUrl;
use Miaoxing\Services\Middleware\LoadAppConfig;
use Miaoxing\User\Middleware\CheckIfEnableRegister;
use Miaoxing\User\Middleware\CheckNotLogin;
use Wei\Request;

class UsersController extends \Miaoxing\Plugin\BaseController
{
    protected $actionAuths = [
        'login' => false,
        'register' => false,
        'create' => false,
        'sendVerifyCode' => false,
    ];

    public function init()
    {
        parent::init();

        $this->middleware(CheckRedirectUrl::class, [
            'only' => ['login', 'logout'],
        ]);

        $this->middleware(CheckNotLogin::class, [
            'only' => ['register', 'create'],
        ]);

        $this->middleware(LoadAppConfig::class, [
            'only' => ['sendVerifyCode'],
        ]);

        $this->middleware(CheckIfEnableRegister::class, [
            'only' => [
                'register',
                'create',
                'sendVerifyCode',
            ],
        ]);
    }

    public function indexAction($req)
    {
        $nav = wei()->nav()->curApp()->enabled()->findOrInit(['type' => 'user']);

        if ($bgImage = wei()->user->bgImage) {
            $this->event->trigger('postImageLoad', [&$bgImage]);
        }

        $this->page->setTitle('个人中心');

        return get_defined_vars();
    }

    /**
     * 用户注册,相当于users/new
     * @param mixed $req
     */
    public function registerAction($req)
    {
        return get_defined_vars();
    }

    /**
     * 获取验证码
     * @param mixed $req
     */
    public function sendVerifyCodeAction($req)
    {
        if (!$req['mobile']) {
            return $this->err('请输入手机号码');
        }

        $cur = User::cur();
        if ($cur->mobile === $req['mobile'] && $cur->isMobileVerified) {
            return $this->err('您已绑定了该手机号码');
        }

        $user = wei()->userModel()->mobileVerified()->find('mobile', $req['mobile']);
        if ($user) {
            return $this->err('该手机号码已经注册，请重新输入');
        }
        $ret = wei()->verifyCode->send($req['mobile']);

        return $this->ret($ret);
    }

    /**
     * 用户注册
     *
     * @param $req
     * @return \Wei\Response
     */
    public function createAction($req)
    {
        // 1. 调用注册接口
        $user = wei()->user();
        $ret = $user->register($req);
        if (1 !== $ret['code']) {
            return $ret;
        }

        // 2. 登录用户
        $loginRet = User::loginById($user['id']);
        if (1 !== $loginRet['code']) {
            return $loginRet;
        }

        return $ret;
    }

    /**
     * 个人信息页面
     *
     * @return array
     * @param mixed $req
     */
    public function editAction($req)
    {
        $user = User::cur();

        $enableMobileVerify = wei()->user->enableMobileVerify;
        $isMobileVerified = $user->mobileVerifiedAt;

        // 如果认证了手机号码,又没启用认证功能,就不显示手机号
        $hideMobile = $isMobileVerified && !$enableMobileVerify;

        $this->page->setTitle('个人信息');

        return get_defined_vars();
    }

    /**
     * 个人信息录入
     *
     * @param $req
     * @return $this|string
     */
    public function regAction($req)
    {
        $ret = User::updateData($req);

        return $ret;
    }

    /**
     * 用户登录
     *
     * @param Request $req
     * @return array|\Wei\Response
     */
    public function loginAction(Request $req)
    {
        if ($req->isPost()) {
            if (wei()->user->enableLoginCaptcha) {
                $ret = wei()->captcha->check($req['captcha']);
                if (1 !== $ret['code']) {
                    $ret['captchaErr'] = true;

                    return $this->ret($ret);
                }
            }

            $ret = User::login($req);

            return $this->ret($ret);
        } else {
            if (!wei()->user->enableLogin) {
                return $this->err(wei()->user->disableLoginTips);
            }
            $this->page->setTitle('登录');

            return get_defined_vars();
        }
    }

    /**
     * 用户退出登录
     *
     * @param $req
     * @return \Wei\Response
     */
    public function logoutAction($req)
    {
        User::logout();

        $next = $req('next', $this->request->getReferer());

        return $this->response->redirect($next);
    }

    /**
     * 账号设置
     *
     * @return array
     */
    public function settingAction()
    {
        $this->page->setTitle('账号设置');

        return get_defined_vars();
    }
}
