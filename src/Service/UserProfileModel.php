<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\CastTrait;
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

    protected $table = 'userProfile';

    protected $data = [
        'config' => [],
    ];

    protected $providers = [
        'db' => 'db',
    ];

    public function getCasts(): array
    {
        return array_merge(parent::getCasts(), [
            'config' => 'json',
        ]);
    }
}
