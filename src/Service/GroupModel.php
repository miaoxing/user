<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Model\CastTrait;
use Miaoxing\Plugin\Model\GetSetTrait;
use Miaoxing\Plugin\Model\QuickQueryTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;
use Miaoxing\Plugin\Service\Group;
use Miaoxing\User\Metadata\GroupTrait;

/**
 * GroupModel
 *
 * @property GroupModel $parent
 */
class GroupModel extends Group
{
    use GroupTrait;
    use CastTrait;
    use QuickQueryTrait;
    use GetSetTrait;
    use SoftDeleteTrait;

    protected $deletedAtColumn = 'deleteTime';

    protected $deletedByColumn = 'deleteUser';

    public function parent()
    {
        return $this->hasOne(wei()->groupModel(), 'parentId', 'id');
    }

    public function afterSave()
    {
        wei()->cache->remove('groups:' . wei()->app->getId());

        parent::beforeSave();
    }

    public function afterDestroy()
    {
        wei()->cache->remove('groups:' . wei()->app->getId());

        parent::beforeSave();
    }
}
