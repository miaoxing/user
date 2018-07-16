<?php

namespace plugins\user\docs {

    /**
     * @property    \Miaoxing\Plugin\Service\CurUser $curUser 当前用户
     *
     * @property    \Miaoxing\Plugin\Service\User $user
     * @method      \Miaoxing\Plugin\Service\User|\Miaoxing\Plugin\Service\User[] user() 用户
     *
     * @property    \Miaoxing\Plugin\Service\User $appUser 产品的用户
     * @method      \Miaoxing\Plugin\Service\User|\Miaoxing\Plugin\Service\User[] appUser()
     *
     * @property    \Miaoxing\Plugin\Service\Group $group 分组
     * @method      \Miaoxing\Plugin\Service\Group|\Miaoxing\Plugin\Service\Group[] group()
     */
    class AutoComplete
    {
    }
}

namespace {

    /**
     * @return \plugins\user\docs\AutoComplete
     */
    function wei()
    {
    }

    $curUser = wei()->curUser;
}
