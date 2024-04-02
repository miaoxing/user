<?php

namespace Miaoxing\User\Job;

use Miaoxing\Plugin\Queue\BaseJob;
use Miaoxing\User\Service\UserModel;
use Wei\Event;

class UserCreate extends BaseJob
{
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): void
    {
        $user = UserModel::findOneById($this->id);

        Event::trigger('asyncUserCreate', [$user]);
    }
}
