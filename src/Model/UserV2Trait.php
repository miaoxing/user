<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\User\Metadata\UserTrait;
use Miaoxing\User\Service\GroupModel;
use Miaoxing\User\Service\UserModel;
use Miaoxing\User\Service\UserProfileModel;

/**
 * @property GroupModel $group
 * @property UserProfileModel $profile
 */
trait UserV2Trait
{
    use UserTrait;
    use CastTrait;
    use QuickQueryTrait;
    use GetSetTrait;

    protected $defaultCasts = [
        'department' => 'json',
        'extAttr' => 'json',
    ];

    public function __construct(array $options = [])
    {
        $this->toArrayV2 = true;
        $this->hidden = array_merge($this->hidden, [
            'salt',
            'password',
        ]);

        parent::__construct($options);
    }

    public function group()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'groupId');
    }

    public function profile()
    {
        return $this->hasOne(wei()->userProfileModel(), 'id', 'id');
    }

    /**
     * Record: 设置未加密的密码
     *
     * @param string $password
     * @return $this
     * @todo password服务和password字段冲突
     */
    public function setPlainPassword($password)
    {
        $this['salt'] || $this['salt'] = wei()->password->generateSalt();
        $this['password'] = wei()->password->hash($password, $this['salt']);

        return $this;
    }

    public function updateMobileIfVerified($save = true, $req = null)
    {
        $req || $req = $this->request;

        // 未校验,或者是输入了新手机,需要校验
        if (!$this->isStatus(UserModel::STATUS_MOBILE_VERIFIED)
            || $this['mobile'] != $req['mobile']
        ) {
            if (!$req['verifyCode']) {
                return $this->err('验证码不能为空');
            }

            $ret = wei()->verifyCode->check($req['mobile'], $req['verifyCode']);
            if ($ret['code'] !== 1) {
                return $ret;
            }
        }

        $this['mobile'] = $req['mobile'];
        $this->setStatus(UserModel::STATUS_MOBILE_VERIFIED, true);
        if ($save) {
            $this->save();
        }

        return $this->suc();
    }
}
