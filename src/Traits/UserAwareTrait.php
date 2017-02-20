<?php

namespace Miaoxing\User\Traits;

use Miaoxing\Plugin\Service\User;

/**
 * @property string $userIdColumn
 */
trait UserAwareTrait
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @return User
     */
    public function getUser()
    {
        $this->user || $this->user = wei()->user()->findOrInitById($this['user_id']);

        return $this->user;
    }
}
