<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Service\User;

class UserLog extends \miaoxing\plugin\BaseModel
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'userLogs';

    /**
     * {@inheritdoc}
     */
    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * @var User
     */
    protected $user;

    public function getUser()
    {
        $this->user || $this->user = wei()->user()->findOrInitById($this['userId']);

        return $this->user;
    }
}
