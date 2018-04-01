<?php

namespace Miaoxing\User\Model;

use Miaoxing\Plugin\Service\User;

/**
 * @property User $user
 */
trait BelongsToUserTrait
{
    public function user()
    {
        return $this->belongsTo(wei()->user());
    }
}
