<?php

namespace Miaoxing\User\Service;

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

    public function group()
    {
        return $this->hasOne(wei()->group(), 'id', 'groupId');
    }
}
