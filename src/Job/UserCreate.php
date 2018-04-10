<?php

namespace Miaoxing\User\Job;

use Miaoxing\Queue\Job;
use Miaoxing\Queue\Service\BaseJob;

class UserCreate extends Job
{
    public function __invoke(BaseJob $job, $data)
    {
        $user = wei()->user()->findOneById($data['id']);

        wei()->event->trigger('asyncUserCreate', [$user]);

        $job->delete();
    }
}
