<?php

namespace Miaoxing\User\Job;

use Miaoxing\Queue\BaseJob;

class UserCreate extends BaseJob
{
    public function __invoke(BaseJob $job, $data)
    {
        $user = wei()->user()->findOneById($data['id']);

        wei()->event->trigger('asyncUserCreate', [$user]);

        $job->delete();
    }
}
