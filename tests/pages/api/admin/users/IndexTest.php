<?php

namespace MiaoxingTest\User\Pages\Api\Admin\Users;

use Carbon\Carbon;
use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Service\User;
use Miaoxing\Plugin\Test\BaseTestCase;
use Miaoxing\Services\Service\SexConst;
use Miaoxing\User\Service\UserModel;
use Wei\Time;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        User::loginById(1);

        $user = UserModel::save([
            'name' => '测试' . time(),
        ]);

        $ret = Tester::getAdminApi('users');

        $this->assertSame($user->name, $ret['data'][0]['name']);
    }

    public function testGetSearch()
    {
        User::loginById(1);

        $user = UserModel::save([
            'name' => '测试' . time(),
            'nickName' => 'nickName',
            'mobile' => '13800138000',
            'sex' => SexConst::SEX_FEMALE,
            'country' => '中国',
            'province' => '广东',
            'city' => '深圳',
        ]);

        $search = [
            'name:ct' => $user->name,
            'nickName:ct' => $user->nickName,
            'sex' => $user->sex,
            'country' => $user->country,
            'province' => $user->province,
            'city' => $user->city,
            'createdAt:ge' => (string) Carbon::now()->subMinute(),
            'createdAt:le' => Time::now(),
        ];

        $ret = Tester::request(['search' => $search])->getAdminApi('users');
        $this->assertSame($user->name, $ret['data'][0]['name']);

        $search['createdAt:ge'] = (string) Carbon::now()->addMinute();
        $ret = Tester::request(['search' => $search])->getAdminApi('users');
        $this->assertEmpty($ret['data']);
    }
}
