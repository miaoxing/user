<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\User\Metadata\UserTrait;
use Miaoxing\User\Service\GroupModel;
use Miaoxing\User\Service\UserModel;
use Miaoxing\User\Service\UserProfileModel;

/**
 * @property GroupModel $group
 * @property UserProfileModel $profile
 * @property bool $isMobileVerified
 */
trait UserV2Trait
{
    use UserTrait;
    use CastTrait;
    use ReqQueryTrait;
    use GetSetTrait;

    protected $defaultCasts = [
        'department' => 'array',
        'extAttr' => 'array',
    ];

    public function __construct(array $options = [])
    {
        $this->toArrayV2 = true;

        $this->hidden = array_merge($this->hidden, [
            'salt',
            'password',
        ]);

        $this->virtual = array_merge($this->virtual, [
            'isMobileVerified',
        ]);

        parent::__construct($options);
    }

    public function group()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'groupId');
    }

    /**
     * @return UserProfileModel
     */
    public function profile()
    {
        return $this->hasOne(wei()->userProfileModel(), 'userId', 'id');
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
        if (!$this->isMobileVerified()
            || $this['mobile'] != $req['mobile']
        ) {
            $ret = $this->checkMobile($req['mobile']);
            if ($ret['code'] !== 1) {
                return $ret;
            }

            if (!$req['verifyCode']) {
                return $this->err('验证码不能为空');
            }

            $ret = wei()->verifyCode->check($req['mobile'], $req['verifyCode']);
            if ($ret['code'] !== 1) {
                return $ret + ['verifyCodeErr' => true];
            }
        }

        if ($this['mobile'] == $req['mobile']) {
            return $this->suc(['changed' => false]);
        }

        $this['mobile'] = $req['mobile'];
        $this->setMobileVerified();
        if ($save) {
            $this->save();
        }
        return $this->suc(['changed' => true]);
    }


    public function getIsMobileVerifiedAttribute()
    {
        return (bool) $this->mobileVerifiedAt;
    }

    public function setIsMobileVerifiedAttribute()
    {
        // do nothing
    }
}
