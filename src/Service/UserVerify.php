<?php

namespace Miaoxing\User\Service;

use miaoxing\plugin\BaseService;

class UserVerify extends BaseService
{
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

    public function verify($data)
    {
        // 1. 超时判断
        $timestamp = isset($data['timestamp']) ? $data['timestamp'] : 0;
        if ($timestamp < time() - 86400) {
            return ['code' => -1, 'message' => '链接超时无效'];
        }

        // 2. 验证用户
        $userId = isset($data['userId']) ? $data['userId'] : 0;
        $user = wei()->user()->findOrInitById($userId);
        if ($user->isNew()) {
            return ['code' => -2, 'message' => '用户不存在'];
        }
        $password = $user['password'];

        // 3. 验证用户
        $nonce = $data['nonce'] ?: '';
        $sign = md5($data['userId'] . $password . $timestamp . $nonce);
        if ($sign != $data['sign']) {
            return ['code' => -3, 'message' => '链接验证无效'];
        }

        return ['code' => 1, 'message' => '验证成功', 'user' => $user];
    }
}
