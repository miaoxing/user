<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Model\ReqQueryTrait;
use Miaoxing\Plugin\Model\SoftDeleteTrait;
use Miaoxing\Plugin\Service\Model;
use Miaoxing\User\Metadata\GroupTrait;

/**
 * GroupModel
 *
 * @property GroupModel $parent
 */
class GroupModel extends Model
{
    use GroupTrait;
    use SoftDeleteTrait;
    use ReqQueryTrait;

    protected $data = [
        'sort' => 50,
    ];

    /**
     * @var GroupModel|GroupModel[]
     */
    protected $parents;

    public function parent()
    {
        return $this->hasOne(wei()->groupModel(), 'id', 'parentId');
    }

    public function afterSave()
    {
        wei()->cache->remove('groups:' . wei()->app->getId());
    }

    public function afterDestroy()
    {
        wei()->cache->remove('groups:' . wei()->app->getId());
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
