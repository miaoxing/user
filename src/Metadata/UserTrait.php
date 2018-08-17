<?php

namespace Miaoxing\User\Metadata;

/**
 * UserTrait
 *
 * @property int $id 主键
 * @property string $outId 外部编号
 * @property int $appUserId app应用的用户编号
 * @property string $wechatOpenId 微信的OpenID
 * @property string $wechatUnionId
 * @property string $wechatUserId 微信UserId
 * @property int $status 二进制状态位,表示手机等是否已验证
 * @property bool $admin
 * @property string $nickName
 * @property string $remarkName
 * @property string $username
 * @property string $name 姓名
 * @property string $email
 * @property string $mobile
 * @property string $phone 手机号码
 * @property string $salt
 * @property string $password
 * @property bool $gender
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $address
 * @property string $signature
 * @property string $headImg
 * @property int $groupId 用户组
 * @property array $department 部门
 * @property string $position 职位
 * @property array $extAttr 额外参数
 * @property float $money 账户余额
 * @property float $rechargeMoney 充值账户余额
 * @property int $score 积分
 * @property string $regTime 注册时间
 * @property string $lastLoginTime
 * @property string $unsubscribeTime 取关时间
 * @property bool $isValid
 * @property bool $enable 是否启用
 * @property int $shopId 所属门店
 * @property string $source 用户来源
 * @property int $createUser
 * @property string $createTime 用户创建时间
 * @property int $updateUser
 * @property string $updateTime
 */
trait UserTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'outId' => 'string',
        'appUserId' => 'int',
        'wechatOpenId' => 'string',
        'wechatUnionId' => 'string',
        'wechatUserId' => 'string',
        'status' => 'int',
        'admin' => 'bool',
        'nickName' => 'string',
        'remarkName' => 'string',
        'username' => 'string',
        'name' => 'string',
        'email' => 'string',
        'mobile' => 'string',
        'phone' => 'string',
        'salt' => 'string',
        'password' => 'string',
        'gender' => 'bool',
        'country' => 'string',
        'province' => 'string',
        'city' => 'string',
        'address' => 'string',
        'signature' => 'string',
        'headImg' => 'string',
        'groupId' => 'int',
        'department' => 'json',
        'position' => 'string',
        'extAttr' => 'json',
        'money' => 'float',
        'rechargeMoney' => 'float',
        'score' => 'int',
        'regTime' => 'datetime',
        'lastLoginTime' => 'datetime',
        'unsubscribeTime' => 'datetime',
        'isValid' => 'bool',
        'enable' => 'bool',
        'shopId' => 'int',
        'source' => 'string',
        'createUser' => 'int',
        'createTime' => 'datetime',
        'updateUser' => 'int',
        'updateTime' => 'datetime',
    ];
}
