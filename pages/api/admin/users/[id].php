<?php

use Miaoxing\Plugin\BasePage;
use Miaoxing\Services\Page\ItemGetTrait;
use Miaoxing\Services\Service\UpdateAction;
use Miaoxing\User\Service\UserModel;
use Wei\Req;
use Wei\V;

return new class () extends BasePage {
    use ItemGetTrait;

    public function patch()
    {
        return UpdateAction::new()
            ->validate(static function (UserModel $user, Req $req) {
                $v = V::defaultOptional();
                $v->setModel($user);
                $v->modelColumn('name', '姓名');
                $v->mobileCn('mobile', '手机')->allowEmpty();
                $ret = $v->check($req);
                if ($ret->isErr()) {
                    return $ret;
                }

                if ($req['isMobileVerified'] && !$req['mobile']) {
                    return err('设置了已验证，则手机号码不能为空');
                }

                if ($req['isMobileVerified']) {
                    $checkMobile = $user->checkMobile($req['mobile']);
                    if ($checkMobile->isErr()) {
                        return $checkMobile;
                    }
                }

                return $ret;
            })
            ->beforeSave(static function (UserModel $user, Req $req) {
                if (isset($req['isMobileVerified'])) {
                    $user->setMobileVerified($req['isMobileVerified']);
                }
            })
            ->exec($this);
    }
};
