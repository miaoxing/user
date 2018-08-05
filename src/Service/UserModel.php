<?php

namespace Miaoxing\User\Service;

use Miaoxing\Pas\Model\ChangeTrait;
use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\Plugin\Service\Group;
use Miaoxing\Plugin\Service\User;

/**
 * @property Group $group
 */
class UserModel extends User
{
    use CastTrait;
    use QuickQueryTrait;
    use GetSetTrait;
    use ChangeTrait;

    protected $auditOnly = [
        'name',
        'mobile',
        'email',
        'groupId',
    ];

    protected $columnNames = [
        'name' => '姓名',
        'mobile' => '手机',
        'email' => '邮箱',
        'groupId' => '组织',
    ];

    public function group()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'groupId');
    }
}
