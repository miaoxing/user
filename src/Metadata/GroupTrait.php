<?php

namespace Miaoxing\User\Metadata;

/**
 * GroupTrait
 *
 * @property int $id 主键
 * @property int $wechatId 微信中的分组ID
 * @property int $wechatParentId 上级wechatId，在企业号为父部门Id
 * @property string $name
 * @property int $wechatCount 微信分组用户数
 * @property int $sort
 * @property int $status
 * @property bool $isCustomerService
 * @property string $createTime
 * @property int $createUser
 * @property string $updateTime
 * @property int $updateUser
 * @property string $deleteTime
 * @property int $deleteUser
 */
trait GroupTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'wechatId' => 'int',
        'wechatParentId' => 'int',
        'name' => 'string',
        'wechatCount' => 'int',
        'sort' => 'int',
        'status' => 'int',
        'isCustomerService' => 'bool',
        'createTime' => 'datetime',
        'createUser' => 'int',
        'updateTime' => 'datetime',
        'updateUser' => 'int',
        'deleteTime' => 'datetime',
        'deleteUser' => 'int',
    ];
}
