<?php

namespace MiaoxingTest\User\Controller\AdminApi;

use Miaoxing\Plugin\Test\BaseControllerTestCase;
use Miaoxing\User\Service\GroupModel;

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
}
