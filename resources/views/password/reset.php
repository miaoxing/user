<?php $view->layout() ?>

<ul id="js-reset-tabs" class="header-tab nav tab-underline">
  <li class="nav-item active">
    <a class="nav-link text-active-primary border-active-primary" href="#tab-mobile" data-toggle="tab">手机找回</a>
  </li>
  <li class="nav-item border-primary">
    <a class="nav-link text-active-primary border-active-primary" href="#tab-email" data-toggle="tab">邮箱找回</a>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane fade show active" id="tab-mobile">
    <form class="form" method="post" id="reset-password-form-by-mobile">
      <div class="form-group">
        <label for="username" class="control-label">
          用户名
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="text" name="username" class="form-control" placeholder="请输入用户名">
        </div>
      </div>

      <div class="form-group">
        <label for="mobile" class="control-label">
          手机号码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="tel" class="js-mobile form-control" id="mobile" name="mobile" placeholder="请输入注册手机号码">
        </div>
      </div>

      <div class="form-group" id="get-verify-code-group">
        <label for="verify-code" class="control-label">
          验证码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <div class="input-group">
            <input type="tel" class="form-control" id="verify-code" name="verifyCode" placeholder="请输入验证码"
              maxlength="6">
                <span class="input-group-append">
                    <button type="button" class="js-verify-code-send btn btn-outline-primary"
                      id="get-verify-code">获取验证码
                    </button>
                </span>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="password" class="control-label">
          新密码
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="password" class="form-control" name="password" placeholder="请输入新密码">
        </div>
      </div>
      <div class="form-group">
        <label for="passwordAgain" class="control-label"></label>

        <div class="col-control">
          <input type="password" class="form-control" name="passwordConfirm" placeholder="请再次输入新密码">
        </div>
      </div>

      <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block">提交</button>
      </div>
    </form>
  </div>

  <div class="tab-pane fade show" id="tab-email">
    <form class="form" method="post" id="reset-password-form-by-email">
      <div class="form-group">
        <label for="email" class="control-label">
          邮箱
          <span class="text-warning">*</span>
        </label>

        <div class="col-control">
          <input type="text" class="form-control" id="email" name="email" placeholder="请输入注册邮箱">
        </div>
      </div>

      <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block">发送验证到邮箱</button>
      </div>
    </form>
  </div>
</div>
<?= $block->js() ?>
<script>
  require(['plugins/app/libs/jquery-form/jquery.form', 'plugins/app/js/bootstrap-tab', 'plugins/verify-code/js/verify-code'], function () {
    // 手机找回
    $('#reset-password-form-by-mobile').ajaxForm({
      url: $.url('password/create-reset-by-mobile'),
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            window.location = $.req('next') || $.url('users');
          }
          if (typeof ret.verifyCodeErr != 'undefined' && ret.verifyCodeErr) {
            $('.js-verify-code-send').verifyCode('reset');
          }
        });
      }
    });

    // 邮箱找回
    $('#reset-password-form-by-email').ajaxForm({
      url: $.url('password/create-reset-by-email'),
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            window.location = $.req('next') || $.url('users');
          }
        });
      }
    });

    // 选项卡
    $('.js-reset-tabs a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    // 发送验证码
    $('.js-verify-code-send').verifyCode({
      url: '<?= $url->query('password/send-verify-code') ?>'
    });
  });
</script>
<?= $block->end() ?>
