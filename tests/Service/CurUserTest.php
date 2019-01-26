<?php

namespace MiaoxingTest\User\Service;

use Miaoxing\Plugin\Service\User;

class CurUserTest extends \Miaoxing\Plugin\Test\BaseTestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->wei->remove('curUser');
        $this->wei->session->clear();
    }

    public function testCurUserSave()
    {
        $this->initSession();
        $curUser = wei()->curUser;

        $curUser->save(['nickName' => 'nickName2']);

        $user = $this->getUser();
        $this->assertEquals($curUser['id'], $user['id']);
        $this->assertEquals('nickName2', $curUser['nickName']);

        $query = wei()->db->getLastQuery();
        $sql = 'UPDATE user SET id = ?, nickName = ?, department = ?, extAttr = ?, updateUser = ?, updateTime = ? ';
        $sql .= 'WHERE id = ?';
        $this->assertEquals($sql, $query);
    }

    public function testLoginByRecordAndSave()
    {
        $user = $this->getUser();
        $curUser = wei()->curUser;

        $ret = $curUser->loginByRecord($user);
        $this->assertRetSuc($ret);

        $curUser->save(['nickName' => 'nickName2']);

        $this->assertEquals('nickName2', $curUser['nickName']);

        $query = wei()->db->getLastQuery();
        $sql = 'UPDATE user SET nickName = ?, updateTime = ?, updateUser = ?, id = ? WHERE id = ?';
        $this->assertEquals($sql, $query);
    }

    public function testCurUserToArray()
    {
        $this->initSession();
        $user = $this->getUser();
        $curUser = wei()->curUser;

        $data = $curUser->toArray();

        $this->assertEquals($user['id'], $data['id']);
        $this->assertEquals($user['nickName'], $data['nickName']);
    }

    public function testUserSaveRefreshCurUserData()
    {
        $curUser = wei()->curUser;
        $curUser->logout();

        $user = $this->getUser();
        $curUser->loginByRecord($user);
        $this->assertEquals('nickName', $curUser['nickName']);

        $user->save(['nickName' => 'nickName2']);
        $this->assertEquals('nickName2', $curUser['nickName']);
    }

    public function testLogout()
    {
        $user = $this->getUser();
        $curUser = wei()->curUser;
        $curUser->loginByRecord($user);

        $this->assertEquals($user['id'], $curUser['id']);

        $curUser->logout();

        $this->assertFalse($curUser->isLogin());
        $this->assertNull($curUser['id']);
    }

    public function testGetDataFromSession()
    {
        // TODO 增加PHP7的支持
        // https://travis-ci.org/miaoxing/user/jobs/217006280
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $this->markTestSkipped('暂不支持');
        }

        $session = $this->getServiceMock('session', ['offsetGet']);
        $session->expects($this->exactly(4))
            ->method('offsetGet')
            ->with('user')
            ->willReturn([
                'id' => '1',
                'nickName' => 'nickName',
            ]);

        // 各触发n次offsetGet
        $this->assertEquals('1', wei()->curUser['id']);
        $this->assertEquals('nickName', wei()->curUser['nickName']);
    }

    public function testGetDataFromDb()
    {
        $user = $this->getUser();
        $this->initSession();

        $curUser = wei()->curUser;

        $this->assertEquals($user['id'], $curUser['id']);
        $this->assertEquals('name', $curUser['name']);
        $this->assertEquals('test@example.com', $curUser['email']);

        $query = wei()->db->getLastQuery();
        $this->assertEquals('SELECT * FROM user WHERE id = ? LIMIT 1', $query);
    }

    /**
     * 模拟curUser未加载数据前的情况
     */
    protected function initSession()
    {
        $user = $this->getUser();
        wei()->session['user'] = $user->toArray(['id']);
    }

    protected function getUser()
    {
        $this->user || $this->user = wei()->user()->save([
            'nickName' => 'nickName',
            'email' => 'test@example.com',
            'name' => 'name',
        ]);

        return $this->user;
    }

    public function testGetId()
    {
        $user = $this->getUser();
        wei()->curUserV2->loginByRecord($user);

        $this->assertInternalType('int', wei()->curUserV2->id);
    }

    public function testGetProfile()
    {
        $this->initSession();

        wei()->userProfileModel()->save([
           'userId' => wei()->curUserV2->id,
        ]);

        $profile = wei()->curUserV2->profile;
        $this->assertNotNull($profile);
        $this->assertEquals(wei()->curUserV2->id, $profile->userId);
    }

    public function testLoadBeforeSet()
    {
        $this->initSession();

        wei()->curUserV2->email = 'abc';
        $this->assertEquals('name', wei()->curUserV2->name);
    }
}
