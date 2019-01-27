<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\User\Metadata\UserProfileTrait;

/**
 * UserProfileModel
 */
class UserProfileModel extends BaseModel
{
    use UserProfileTrait;
    use CastTrait;
    use ReqQueryTrait;
    use GetSetTrait;

    protected $table = 'userProfile';

    protected $defaultCasts = [
        'config' => 'array'
    ];

    protected $data = [
        'config' => [],
    ];

    protected $providers = [
        'db' => 'db',
    ];
}
