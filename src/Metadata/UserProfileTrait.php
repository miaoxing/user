<?php

namespace Miaoxing\User\Metadata;

/**
 * UserProfileTrait
 *
 * @property int $id 主键
 * @property int $userId 用户id
 * @property string $name 姓名
 * @property string $contact 联系方式
 * @property string $sex 用户性别
 * @property string $age 用户年龄
 * @property string $birthday 用户生日
 * @property string $height 用户身高
 * @property string $weight 用户体重
 * @property string $degree 用户学历
 * @property string $province 用户所在省份
 * @property string $city 用户所在城市
 * @property string $area
 * @property string $address 地址
 * @property string $zipcode 邮政编码
 * @property string $email 用户E-mail
 * @property string $idcard 身份证号
 * @property string $bloodType 用户血型
 * @property string $career 用户职业
 * @property string $college 毕业院校
 * @property string $homePage 用户主页
 * @property string $favorite 用户爱好
 * @property string $personalDesc 用户个人说明
 * @property array $config
 * @property string $createTime 创建时间
 */
trait UserProfileTrait
{
    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'userId' => 'int',
        'name' => 'string',
        'contact' => 'string',
        'sex' => 'string',
        'age' => 'string',
        'birthday' => 'string',
        'height' => 'string',
        'weight' => 'string',
        'degree' => 'string',
        'province' => 'string',
        'city' => 'string',
        'area' => 'string',
        'address' => 'string',
        'zipcode' => 'string',
        'email' => 'string',
        'idcard' => 'string',
        'bloodType' => 'string',
        'career' => 'string',
        'college' => 'string',
        'homePage' => 'string',
        'favorite' => 'string',
        'personalDesc' => 'string',
        'config' => 'array',
        'createTime' => 'datetime',
    ];
}
