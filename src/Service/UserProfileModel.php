<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\User\Metadata\UserProfileTrait;

/**
 * UserProfileModel
 */
class UserProfileModel extends BaseModel
{
    use UserProfileTrait;
    use CastTrait;
    use QuickQueryTrait;
    use GetSetTrait;

    protected $table = 'userProfile';

    protected $providers = [
        'db' => 'db',
    ];
}
