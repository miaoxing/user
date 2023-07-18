<?php

namespace Miaoxing\User\Model;

use Miaoxing\User\Service\UserModel;

/**
 * @property UserModel $user
 * @deprecated Use BelongsToUserTrait
 */
trait BelongsToUserModelTrait
{
    /**
     * @return UserModel
     * @Relation
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
