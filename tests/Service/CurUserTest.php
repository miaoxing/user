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
        $session = $this->getServiceMock('session', ['offsetGet']);

        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $count = $this->any();
        } else {
            $count = $this->exactly(4);
        }

        $session->expects($count)
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
}
