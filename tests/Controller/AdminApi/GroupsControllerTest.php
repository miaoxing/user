<?php

namespace MiaoxingTest\User\Controller\AdminApi;

use Miaoxing\Plugin\Test\BaseControllerTestCase;
use Miaoxing\Admin\Service\GroupModel;

class GroupsControllerTest extends BaseControllerTestCase
{
    public function testCreateAction()
    {
        $name = '测试分组' . time();

        $ret = $this->visitCurPage(['name' => $name])->login()->json()->response();
        $this->assertRetSuc($ret);

        $group = GroupModel::desc('id')->first();
        $this->assertSame($name, $group->name);
    }

    public function testDestroyAction()
    {
        $group = GroupModel::save();

        $ret = $this->visitCurPage(['id' => $group->id])->login()->json()->response();
        $this->assertRetSuc($ret);

        $group2 = GroupModel::find($group->id);
        $this->assertNull($group2);
    }
}
