<?php

namespace Miaoxing\User\Service;

class UserProfile extends \miaoxing\plugin\BaseModel
{
    protected $data = [
        'config' => []
    ];

    public function afterFind()
    {
        parent::afterFind();

        $this['config'] = (array)json_decode($this['config'], true);

        $this->event->trigger('postImageDataLoad', [&$this, ['config']]);
    }

    public function beforeSave()
    {
        parent::beforeSave();

        $this->event->trigger('preImageDataSave', [&$this, ['images', 'detail']]);

        $this['config'] = json_encode($this['config'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
