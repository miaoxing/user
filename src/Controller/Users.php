<?php

namespace Miaoxing\User\Controller;

use Miaoxing\User\Middleware\CheckNotLogin;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Middleware\CheckRedirectUrl;
use Miaoxing\Plugin\Middleware\LoadAppConfig;
use Miaoxing\User\Middleware\CheckIfEnableRegister;
use Wei\Request;

class Users extends \miaoxing\plugin\BaseController
{
    protected $guestPages = [
        'users/login',
        'users/register',
        'users/create',
        'users/sendVerifyCode',
    ];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->middleware(CheckRedirectUrl::className(), [
            'only' => ['login', 'logout'],
        ]);

        $this->middleware(CheckNotLogin::className(), [
            'only' => ['register', 'create'],
        ]);

        $this->middleware(LoadAppConfig::className(), [
            'only' => ['sendVerifyCode'],
        ]);

        $this->middleware(CheckIfEnableRegister::className(), [
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

        if ($bgImage = $this->setting('user.bgImage')) {
            $this->event->trigger('postImageLoad', [&$bgImage]);
        }

        $headerTitle = '个人中心';

        return get_defined_vars();
    }

    /**
     * 用户注册,相当于users/new
     */
    public function registerAction($req)
    {
        return get_defined_vars();
    }

    /**
     * 获取验证码
     */
    public function sendVerifyCodeAction($req)
    {
        if (!$req['mobile']) {
            return $this->err('请输入手机号码');
        }

        $user = wei()->user()->withStatus(User::STATUS_MOBILE_VERIFIED)->find(['mobile' => $req['mobile']]);
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
        if ($ret['code'] !== 1) {
            return $this->ret($ret);
        }

        // 2. 登录用户
        $loginRet = wei()->curUser->loginById($user['id']);
        if ($loginRet['code'] !== 1) {
            return $loginRet;
        }

        return $this->ret($ret);
    }

    /**
     * 个人信息页面
     *
     * @return array
     */
    public function infoAction($req)
    {
        $user = $this->curUser;

        $enableMobileVerify = $this->setting('user.enableMobileVerify', false);
        $isMobileVerified = $user->isStatus(User::STATUS_MOBILE_VERIFIED);

        // 如果认证了手机号码,又没启用认证功能,就不显示手机号
        $hideMobile = $isMobileVerified && !$enableMobileVerify;

        $headerTitle = '个人信息';

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
        $ret = $this->curUser->updateData($req);

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
            if (wei()->setting('user.enableLoginCaptcha')) {
                $ret = wei()->captcha->check($req['captcha']);
                if ($ret['code'] !== 1) {
                    $ret['captchaErr'] = true;

                    return $this->ret($ret);
                }
            }

            $ret = $this->curUser->login($req);

            return $this->ret($ret);
        } else {
            if (!$this->setting('user.enableLogin', true)) {
                return $this->err($this->setting('user.disableLoginTips', '登录功能未启用'));
            }
            $headerTitle = '登录';

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
        wei()->curUser->logout();

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
        $headerTitle = '账号设置';

        return get_defined_vars();
    }
}
