<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Service\User;
use Miaoxing\User\Service\UserModel;

/**
 * @property User $user
 */
trait BelongsToUserTrait
{
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
