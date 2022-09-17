<?php

use Miaoxing\Plugin\BaseController;
use Miaoxing\Services\Page\ItemGetTrait;
use Miaoxing\Services\Service\UpdateAction;
use Miaoxing\User\Service\UserModel;
use Wei\Req;
use Wei\V;

return new class () extends BaseController {
    use ItemGetTrait;

    public function patch()
    {
        return UpdateAction::new()
            ->beforeFind(function (UserModel $user, Req $req) {
                $v = V::defaultOptional();
                $v->mobileCn('mobile', '手机')->allowEmpty();
                $ret = $v->check($req);
                if ($ret->isErr()) {
                    return $ret;
                }

                if ($req['isMobileVerified'] && !$req['mobile']) {
                    return err('设置了已验证，则手机号码不能为空');
                }

                if ($req['isMobileVerified']) {
                    return $user->checkMobile($req['mobile']);
                }
            })
            ->beforeSave(function (UserModel $user, Req $req) {
                if (isset($req['isMobileVerified'])) {
                    $user->setMobileVerified($req['isMobileVerified']);
                }
            })
            ->exec($this);
    }
};
