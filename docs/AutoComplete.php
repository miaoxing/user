<?php

namespace MiaoxingDoc\User {

    /**
     * @property    \Miaoxing\User\Service\UserModel $userModel UserModel
     * @method      \Miaoxing\User\Service\UserModel|\Miaoxing\User\Service\UserModel[] userModel()
     *
     * @property    \Miaoxing\User\Service\UserPassword $userPassword
     *
     * @property    \Miaoxing\User\Service\UserProfile $userProfile
     * @method      \Miaoxing\User\Service\UserProfile|\Miaoxing\User\Service\UserProfile[] userProfile()
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

    /** @var Miaoxing\User\Service\UserModel $userModel */
    $user = wei()->userModel();

    /** @var Miaoxing\User\Service\UserModel|Miaoxing\User\Service\UserModel[] $userModels */
    $users = wei()->userModel();

    /** @var Miaoxing\User\Service\UserPassword $userPassword */
    $userPassword = wei()->userPassword;

    /** @var Miaoxing\User\Service\UserProfile $userProfile */
    $userProfile = wei()->userProfile;

    /** @var Miaoxing\User\Service\UserVerify $userVerify */
    $userVerify = wei()->userVerify;
}
