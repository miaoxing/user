<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\BaseService;

class UserVerify extends BaseService
{
    const EXPIRE = 86400;

    public function generate($user)
    {
        $nonce = wei()->random->string(32);
        $timestamp = time();
        $userId = $user['id'];
        $password = $user['password'];
        $sign = md5($userId . $password . $timestamp . $nonce);

        return [
            'nonce' => $nonce,
            'timestamp' => $timestamp,
            'userId' => $userId,
            'sign' => $sign,
        ];
    }

    /**
     * @param $data
     * @param bool $isOnly 是否已访问过
     * @return array
     */
    public function verify($data, $isOnly = true)
    {
        // 1. 超时判断
        $timestamp = isset($data['timestamp']) ? $data['timestamp'] : 0;
        if ($timestamp < time() - static::EXPIRE) {
            return ['code' => -1, 'message' => '链接超时无效'];
        }

        // 2. 验证用户
        $userId = isset($data['userId']) ? $data['userId'] : 0;
        $user = wei()->user()->findOrInitById($userId);
        if ($user->isNew()) {
            return ['code' => -2, 'message' => '用户不存在'];
        }
        $password = $user['password'];

        // 3. 验证签名是否正确
        $nonce = $data['nonce'] ?: '';
        $sign = md5($data['userId'] . $password . $timestamp . $nonce);
        if ($sign != $data['sign']) {
            return ['code' => -3, 'message' => '链接验证无效'];
        }

        // 4. 验证码链接是否被用过
        if ($isOnly && !wei()->cache->add('user:verify:' . $sign, true, static::EXPIRE)) {
            return ['code' => -4, 'message' => '链接被访问过'];
        }

        return ['code' => 1, 'message' => '验证成功', 'user' => $user];
    }
}
