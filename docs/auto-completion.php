<?php

/**
 * @property    Miaoxing\User\Service\UserModel $userModel
 * @method      Miaoxing\User\Service\UserModel|Miaoxing\User\Service\UserModel[] userModel($table = null)
 */
class UserModelMixin {
}

/**
 * @property    Miaoxing\User\Service\UserPassword $userPassword
 */
class UserPasswordMixin {
}

/**
 * @property    Miaoxing\User\Service\UserProfile $userProfile
 * @method      Miaoxing\User\Service\UserProfile|Miaoxing\User\Service\UserProfile[] userProfile()
 */
class UserProfileMixin {
}

/**
 * @property    Miaoxing\User\Service\UserProfileModel $userProfileModel UserProfileModel
 * @method      Miaoxing\User\Service\UserProfileModel|Miaoxing\User\Service\UserProfileModel[] userProfileModel()
 */
class UserProfileModelMixin {
}

/**
 * @property    Miaoxing\User\Service\UserVerify $userVerify
 */
class UserVerifyMixin {
}

/**
 * @mixin UserModelMixin
 * @mixin UserPasswordMixin
 * @mixin UserProfileMixin
 * @mixin UserProfileModelMixin
 * @mixin UserVerifyMixin
 */
class AutoCompletion {
}

/**
 * @return AutoCompletion
 */
function wei()
{
    return new AutoCompletion;
}

/** @var Miaoxing\User\Service\UserModel $userModel */
$user = wei()->userModel();

/** @var Miaoxing\User\Service\UserModel|Miaoxing\User\Service\UserModel[] $userModels */
$users = wei()->userModel();

/** @var Miaoxing\User\Service\UserPassword $userPassword */
$userPassword = wei()->userPassword;

/** @var Miaoxing\User\Service\UserProfile $userProfile */
$userProfile = wei()->userProfile;

/** @var Miaoxing\User\Service\UserProfileModel $userProfileModel */
$userProfile = wei()->userProfileModel();

/** @var Miaoxing\User\Service\UserProfileModel|Miaoxing\User\Service\UserProfileModel[] $userProfileModels */
$userProfiles = wei()->userProfileModel();

/** @var Miaoxing\User\Service\UserVerify $userVerify */
$userVerify = wei()->userVerify;
