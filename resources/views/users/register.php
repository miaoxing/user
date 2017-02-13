<?php $view->layout() ?>

<div class="form-legend clearfix">
  <a class="pull-right" href="<?= $url->query('users/login') ?>">登录</a>
</div>

<ul class="js-register-tabs nav tab-underline border-bottom">
  <li class="active border-primary"><a class="text-active-primary" href="#tabMobile" data-toggle="tab">手机注册</a></li>
  <li class="border-primary"><a class="text-active-primary" href="#tabEmail" data-toggle="tab">邮箱注册</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane fade in active" id="tabMobile">
    <form class="js-register-form form" method="post" action="<?= $url->query('users/create') ?>">
      <div class="form-group">
        <label for="mobile" class="control-label">
          手机号码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="tel" class="js-mobile form-control" id="mobile" name="mobile" placeholder="请输入手机号码"
                 value="<?= $curUser['mobile'] ?>">
        </div>
      </div>

      <div class="form-group">
        <label for="verifyCode" class="control-label">
          验证码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <div class="input-group">
            <input type="tel" class="form-control" id="verifyCode" name="verifyCode" placeholder="请输入验证码">
                <span class="input-group-btn border-left">
                    <button type="button" class="js-verify-code-send text-primary btn btn-default form-link"
                            id="getVerifyCode">获取验证码
                    </button>
                </span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="control-label">
          密码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="password" class="form-control" name="password" placeholder="请输入密码">
        </div>
      </div>

      <div class="form-group">
        <label for="passwordAgain" class="control-label"></label>

        <div class="col-control">
          <input type="password" class="form-control" name="passwordConfirm" placeholder="请再次输入密码">
        </div>
      </div>

      <div class="form-footer">
        <input type="hidden" name="source" id="source" value="<?= (int) $req['fromAppId'] ?>">
        <button type="submit" class="btn btn-primary btn-block">注册</button>
      </div>
    </form>
  </div>

  <div class="tab-pane fade in" id="tabEmail">
    <form class="js-register-form form" method="post" action="<?= $url->query('users/create') ?>">
      <div class="form-group">
        <label for="email" class="control-label">
          邮箱
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="text" class="form-control" id="email" name="email" placeholder="请输入您的邮箱">
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="control-label">
          密码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="password" class="form-control" name="password" placeholder="请输入密码">
        </div>
      </div>
      <div class="form-group">
        <label for="passwordAgain" class="control-label"></label>

        <div class="col-control">
          <input type="password" class="form-control" name="passwordConfirm" placeholder="请再次输入密码">
        </div>
      </div>

      <div class="form-footer">
        <input type="hidden" name="source" id="source" value="<?= (int) $req['fromAppId'] ?>">
        <button type="submit" class="btn btn-primary btn-block">注册</button>
      </div>
    </form>
  </div>
</div>

<?= $block('js') ?>
<script>
  require(['jquery-form', 'plugins/verify-code/js/verify-code', 'assets/bsTab'], function () {
    $('.js-register-form').ajaxForm({
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code == 1) {
            window.location = $.req('next') || $.url('users');
          }

          if (typeof ret.verifyCodeErr != 'undefined' && ret.verifyCodeErr) {
            $('.js-verify-code-send').verifyCode('reset');
          }
        });
      }
    });

    $('.js-register-tabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    // 发送验证码
    $('.js-verify-code-send').verifyCode({
      url: '<?= $url->query('users/send-verify-code') ?>'
    });

  });
</script>
<?= $block->end() ?>
