<?php

namespace Miaoxing\User\Model;

use Miaoxing\Admin\Service\GroupModel;

/**
 * @property GroupModel $group
 */
trait BelongsToGroupTrait
{
    public function group()
    {
        return $this->belongsTo(wei()->groupModel());
    }
}
