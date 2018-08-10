<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Service\User;

/**
 * @property User $user
 */
trait BelongsToUserModelTrait
{
    public function user()
    {
        return $this->belongsTo(wei()->userModel());
    }
}
