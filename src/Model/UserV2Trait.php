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

    public function group()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'groupId');
    }
}
