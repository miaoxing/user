<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\User\Metadata\UserTrait;
use Miaoxing\User\Service\GroupModel;

/**
 * @property GroupModel $group
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
}
