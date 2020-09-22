<?php

namespace MiaoxingTest\User\Pages\AdminApi\Users;

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

        $request = [
            'name$ct' => $user->name,
            'nickName$ct' => $user->nickName,
            'sex' => $user->sex,
            'country' => $user->country,
            'province' => $user->province,
            'city' => $user->city,
            'createdAtMin' => (string) Carbon::now()->subMinute(),
            'createdAtMax' => Time::now(),
        ];

        $ret = Tester::request($request)->getAdminApi('users');
        $this->assertSame($user->name, $ret['data'][0]['name']);

        $request['createdAtMin'] = (string) Carbon::now()->addMinute();
        $ret = Tester::request($request)->getAdminApi('users');
        $this->assertEmpty($ret['data']);
    }
}
