<?php

namespace Miaoxing\User\Model;

use Miaoxing\User\Service\UserModel;

/**
 * @property UserModel $user
 */
trait BelongsToUserTrait
{
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
