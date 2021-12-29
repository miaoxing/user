<?php

namespace Miaoxing\User\Model;

use Miaoxing\User\Service\UserModel;

/**
 * @property UserModel $user
 */
trait BelongsToUserModelTrait
{
    /**
     * @return UserModel
     * @Relation
     */
    public function user()
    {
        return $this->belongsTo(wei()->userModel());
    }
}
