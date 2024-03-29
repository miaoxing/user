<?php

namespace Miaoxing\User\Controller;

use Miaoxing\Plugin\Service\User;
use Miaoxing\Services\Middleware\LoadAppConfig;

class PasswordController extends \Miaoxing\Plugin\BaseController
{
    protected $actionAuths = [
        'reset' => false,
        'resetReturn' => false,
        'resetUpdate' => false,
        'createReset' => false,
        'sendVerifyCode' => false,
    ];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // @phpstan-ignore-next-line
        $this->middleware(LoadAppConfig::class, [
            'only' => ['sendVerifyCode'],
        ]);
    }

    public function indexAction($req)
    {
        $this->page->setTitle('修改密码');

        return get_defined_vars();
    }

    public function resetAction($req)
    {
        $this->page->setTitle('忘记密码');

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $ret = User::updatePassword($req);

        return $ret;
    }

    /**
     * 验证手机跟用户名并修改密码
     * @param $req
     * @return \Wei\Res
     */
    public function createResetByMobileAction($req)
    {
        // Step1 校验
        $validator = wei()->validate([
            'data' => $req,
            'rules' => [
                'username' => [
                    'length' => [3, 30],
                    'required' => true,
                    'alnum' => true,
                    'callback' => static function ($input) {
                        return !wei()->isDigit($input[0]);
                    },
                ],
                'mobile' => [
                    'required' => true,
                ],
                'verifyCode' => [
                    'required' => true,
                ],
                'password' => [
                    'minLength' => 6,
                ],
                'passwordConfirm' => [
                    'equalTo' => $req['password'],
                ],
            ],
            'names' => [
                'username' => '用户名',
                'mobile' => '手机号',
                'verifyCode' => '验证码',
                'password' => '密码',
                'passwordConfirm' => '重复密码',
            ],
            'messages' => [
                'username' => [
                    'required' => '请输入用户名',
                    'length' => '请输入3-30字符以内的用户名',
                ],
                'mobile' => [
                    'required' => '请输入手机号码',
                ],
                'verifyCode' => [
                    'required' => '请输入验证码',
                ],
                'passwordConfirm' => [
                    'equalTo' => '两次输入的密码不相等',
                ],
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        // Step2 检查用户名跟手机号是否一致
        $user = wei()->user()->findOrInit(['username' => $req['username']]);
        if ($user->isNew()) {
            return $this->err('用户名不存在');
        }

        if ($user['mobile'] != $req['mobile']) {
            return $this->err('手机号码跟用户名不属于同一个用户');
        }

        // Step3 检查验证码是否正确
        $ret = wei()->verifyCode->check($req['mobile'], $req['verifyCode']);
        if (1 !== $ret['code']) {
            return $this->ret($ret + ['verifyCodeErr' => true]);
        }

        // Step4 修改密码
        $user->setPlainPassword($req['password']);
        $user->save();

        return $this->suc();
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

        $user = wei()->user()->mobileVerified()->find(['mobile' => $req['mobile']]);
        if (!$user) {
            return $this->err('不存在该手机号码，请重新输入');
        }
        $ret = wei()->verifyCode->send($req['mobile']);

        return $this->ret($ret);
    }

    /**
     * 验证邮箱跟用户名并发送验证到邮箱
     * @param $req
     * @return \Wei\Res
     */
    public function createResetByEmailAction($req)
    {
        $ret = wei()->userPassword->createResetByEmail($req);

        return $this->ret($ret);
    }

    /**
     * 重置密码页面
     * @param $req
     * @return array
     */
    public function resetReturnAction($req)
    {
        $ret = wei()->userVerify->verify($req, false);
        if ($ret['code'] < 0) {
            return $this->err($ret['message']);
        }

        if (!wei()->ua->isWeChat()) {
            return wei()->res->redirect(wei()->url->full('registration/reset', $req->getQueries()));
        }

        $this->page->setTitle('重置密码');
        $userId = $req['userId'];
        $nonce = $req['nonce'];
        $timestamp = $req['timestamp'];
        $sign = $req['sign'];

        return get_defined_vars();
    }

    /**
     * 重置密码更新数据库
     * @param $req
     * @return \Wei\Res
     */
    public function resetUpdateAction($req)
    {
        $ret = wei()->userPassword->resetPassword($req);

        return $this->ret($ret);
    }
}
