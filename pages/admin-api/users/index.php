<?php

use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Service\IndexAction;
use Miaoxing\User\Service\UserModel;

return new class extends BaseController {
    public function get()
    {
        return IndexAction
            ::beforeFind(function (UserModel $models) {
                $models->reqQuery()
                    ->between(['createdAt']);
            })
            ->exec($this);
    }
};
