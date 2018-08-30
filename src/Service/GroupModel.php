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

    /**
     * @var GroupModel|GroupModel[]
     */
    protected $parents;

    protected $deletedAtColumn = 'deleteTime';

    protected $deletedByColumn = 'deleteUser';

    public function parent()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'parentId');
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

    public function getFullName()
    {
        return implode('-', array_reverse($this->getParents()->getAll('name')));
    }

    /**
     * 获取分组的所有上级分组
     *
     * @return GroupModel|GroupModel[]
     * @throws \Exception
     */
    public function getParents()
    {
        if (!$this->parents) {
            $groups = wei()->group->getGroupsFromCache();

            $parents = wei()->groupModel()->beColl();
            $parents[] = $this;

            $group = $this;
            while ($group->parentId) {
                $group = $groups[$group->parentId];
                $parents[] = $group;
            }

            $this->parents = $parents;
        }

        return $this->parents;
    }
}
