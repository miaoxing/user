<?php

namespace Miaoxing\User\Controller;

use Miaoxing\Plugin\Service\User;

class UserMobileController extends \Miaoxing\Plugin\BaseController
{
    public function indexAction($req)
    {
        $ret = $this->checkBind();
        if (1 !== $ret['code']) {
            return $this->ret($ret);
        }

        return get_defined_vars();
    }

    public function createAction($req)
    {
        $ret = User::bindMobile($req);

        return $ret;
    }

    public function checkAction($req)
    {
        return $this->checkMobile($req['mobile']);
    }

    /**
     * 检查用户是否可以绑定手机号码
     *
     * 注意: 如果是后台用户,已经通过appUserId和app库绑定,不能再绑定
     *
     * @return array
     */
    protected function checkBind()
    {
        if (User::cur()->mobileVerifiedAt) {
            return $this->err('您已经绑定过手机号码', -1);
        }

        return $this->suc('您可以绑定');
    }

    /**
     * 检查手机号码是否可以绑定,是否要注册
     *
     * @param string $mobile
     * @return array
     */
    protected function checkMobile($mobile)
    {
        // 1. 数据校验
        $validator = wei()->validate([
            'data' => [
                'mobile' => $mobile,
            ],
            'rules' => [
                'mobile' => [
                    'required' => true,
                    'mobileCn' => true,
                ],
            ],
            'names' => [
                'mobile' => '手机号码',
            ],
        ]);
        if (!$validator->isValid()) {
            return $this->err($validator->getFirstMessage());
        }

        // 2. 用户是否已绑定
        $ret = $this->checkBind();
        if (1 !== $ret['code']) {
            return $ret;
        }

        // 3. 手机号是否被其他人绑定
        return User::checkMobile($mobile);
    }
}
