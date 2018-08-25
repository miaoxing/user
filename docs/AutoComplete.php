<?php

namespace MiaoxingDoc\User {

    /**
     * @property    \Miaoxing\User\Service\CurUserV2 $curUserV2
     * @method      \Miaoxing\User\Service\CurUserV2|\Miaoxing\User\Service\CurUserV2[] curUserV2()
     *
     * @property    \Miaoxing\User\Service\GroupModel $groupModel GroupModel
     * @method      \Miaoxing\User\Service\GroupModel|\Miaoxing\User\Service\GroupModel[] groupModel()
     *
     * @property    \Miaoxing\User\Service\UserModel $userModel
     * @method      \Miaoxing\User\Service\UserModel|\Miaoxing\User\Service\UserModel[] userModel()
     *
     * @property    \Miaoxing\User\Service\UserPassword $userPassword
     *
     * @property    \Miaoxing\User\Service\UserProfile $userProfile
     * @method      \Miaoxing\User\Service\UserProfile|\Miaoxing\User\Service\UserProfile[] userProfile()
     *
     * @property    \Miaoxing\User\Service\UserProfileModel $userProfileModel UserProfileModel
     * @method      \Miaoxing\User\Service\UserProfileModel|\Miaoxing\User\Service\UserProfileModel[] userProfileModel()
     *
     * @property    \Miaoxing\User\Service\UserVerify $userVerify
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return MiaoxingDoc\User\AutoComplete
     */
    function wei()
    {
    }

    /** @var Miaoxing\User\Service\CurUserV2 $curUserV2 */
    $curUserV2 = wei()->curUserV2;

    /** @var Miaoxing\User\Service\GroupModel $groupModel */
    $group = wei()->groupModel();

    /** @var Miaoxing\User\Service\GroupModel|Miaoxing\User\Service\GroupModel[] $groupModels */
    $groups = wei()->groupModel();

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
}
