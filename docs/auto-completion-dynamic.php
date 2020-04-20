<?php

namespace Miaoxing\User\Service;

class Group extends \Miaoxing\Plugin\BaseModel
{
    /**
     * @param array|string $columns
     * @return $this
     * @see Group::like
     */
    public function like($columns)
    {
    }
}

class GroupModel extends \Miaoxing\Plugin\Service\Model
{
    /**
     * @param mixed $conditions
     * @return $this
     * @see GroupModel::reallyDestroy
     */
    public function reallyDestroy($conditions = false)
    {
    }

    /**
     * @return $this
     * @see GroupModel::withoutDeleted
     */
    public function withoutDeleted()
    {
    }

    /**
     * @return $this
     * @see GroupModel::onlyDeleted
     */
    public function onlyDeleted()
    {
    }

    /**
     * @return $this
     * @see GroupModel::withDeleted
     */
    public function withDeleted()
    {
    }

    /**
     * @param array|string $columns
     * @return $this
     * @see GroupModel::like
     */
    public function like($columns)
    {
    }
}

class UserModel extends \Miaoxing\Plugin\Service\UserModel
{
    /**
     * Record: 检查指定的手机号码能否绑定当前用户
     *
     * @param string $mobile
     * @return array
     * @see UserModel::checkMobile
     */
    public function checkMobile(string $mobile)
    {
    }

    /**
     * Record: 绑定手机
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @see UserModel::bindMobile
     */
    public function bindMobile($data)
    {
    }

    /**
     * Record: 更新当前用户资料
     *
     * @param array|\ArrayAccess $data
     * @return array
     * @see UserModel::updateData
     */
    public function updateData($data)
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
    public function like($columns)
    {
    }
}

class UserVerify extends \Miaoxing\Plugin\BaseService
{
}
