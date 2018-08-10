<?php

namespace Miaoxing\User\Model;

use Miaoxing\User\Service\UserModel;

/**
 * @property UserModel $user
 */
trait BelongsToUserModelTrait
{
    public function user()
    {
        return $this->belongsTo(wei()->userModel());
    }
}
