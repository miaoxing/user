<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\User\Metadata\UserProfileTrait;

/**
 * UserProfileModel
 */
class UserProfileModel extends BaseModel
{
    use ModelTrait;
    use ReqQueryTrait;
    use UserProfileTrait;

    protected $table = 'userProfile';

    protected $attributes = [
        'config' => [],
    ];

    protected $columns = [
        'config' => [
            'cast' => 'json',
        ],
    ];
}
