<?php

namespace Miaoxing\User\Service;

class UserModel extends \Miaoxing\Plugin\Service\UserModel
{
    /**
     * Record: 检查指定的手机号码能否绑定当前用户
     *
     * @param string $mobile
     * @return array
     * @see UserModel::checkMobile
     */
    public static function checkMobile(string $mobile)
    {
    }

    /**
     * Record: 绑定手机
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @see UserModel::bindMobile
     */
    public static function bindMobile($data)
    {
    }

    /**
     * Record: 更新当前用户资料
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @see UserModel::updateData
     */
    public static function updateData($data)
    {
    }
}

class UserPassword extends \Miaoxing\Plugin\BaseService
{
}

class UserProfile extends \Miaoxing\Plugin\BaseModel
{
}

class UserProfileModel extends \Miaoxing\Plugin\BaseModel
{
    /**
     * @param array|string $columns
     * @return $this
     * @see UserProfileModel::like
     */
    public static function like($columns)
    {
    }
}

class UserVerify extends \Miaoxing\Plugin\BaseService
{
}
