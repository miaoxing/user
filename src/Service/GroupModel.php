<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\Plugin\Service\Group;

/**
 * GroupModel
 */
class GroupModel extends Group
{
    use CastTrait;
    use QuickQueryTrait;
    use GetSetTrait;
}
