<?php

$view->layout('@admin/admin/layout-light.php')
?>

<div class="page-header">
  <h1 class="page-title-light">
    注册
  </h1>
</div>
<!-- /.page-header -->

<div class="page-body row">
  <div class="col-12">

    <form class="js-register-form" role="form" method="post" action="<?= $url('registration/create') ?>">

      <div class="form-group">
        <label for="email">
          邮箱
        </label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password">
          密码
        </label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="form-text with-errors"></div>
      </div>

      <div class="form-group">
        <label for="password-confirm">
          确认密码
        </label>
        <input type="password" class="form-control" id="password-confirm" name="passwordConfirm" required
          data-rule-equalto="#password">
      </div>

      <div class="form-group">
        <label for="captcha">
          验证码
        </label>
        <div class="input-group">
          <input type="text" class="form-control" id="captcha" name="captcha" placeholder="请输入验证码" required>
          <span class="input-group-append">
            <span class="input-group-text p-0">
              <img class="js-captcha" src="<?= $url('captcha') ?>">
            </span>
          </span>
        </div>
        <div class="form-text with-errors"></div>
      </div>

      <?php if ($agreementArticleId) : ?>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="agreement" name="agreement" value="1">
            <label class="custom-control-label" for="agreement">
              同意<a class="js-agreement" href="javascript:;">服务协议</a>
            </label>
          </div>
        </div>
      <?php endif ?>

      <div class="form-group">
        <div class="js-ret-message text-center">
          &nbsp;
        </div>
      </div>

      <div class="clearfix form-group mt-4">
        <button class="btn btn-primary btn-block btn-lg" type="submit">
          注册
        </button>
      </div>
    </form>

    <hr>
    <div class="mt-3 text-center">
      已有账号，点击<a href="<?= $url('admin/login') ?>">登录</a>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="js-agreement-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="agreement-modal-label"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agreement-modal-label">服务协议</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="js-agreement-content modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>

<?= $block->js() ?>
<script>
  require(['plugins/admin/js/form', 'plugins/user/js/users', 'plugins/app/js/validator'], function (form, users) {
    $('.js-register-form')
      .ajaxForm({
        loading: true,
        dataType: 'json',
        beforeSubmit: function (arr, $form) {
          return $form.valid();
        },
        success: function (ret) {
          users.pageMsg(ret, function () {
            if (typeof ret.captchaErr != 'undefined' && ret.captchaErr === true) {
              changeCaptcha();
            }

            if (ret.code == 1) {
              window.location = $.url('registration/confirm');
            }
          });
        }
      }).validate();

    var $captcha = $('.js-captcha');
    $captcha.click(changeCaptcha);

    $('.js-agreement').click(function () {
      $.ajax({
        loading: true,
        url: $.url('articles/%s.json', <?= (int) $agreementArticleId ?>),
        dataType: 'json',
        success: function (ret) {
          if (ret.code === 1) {
            $('.js-agreement-content').html(ret.data.content);
            $('.js-agreement-modal').modal('show');
          } else {
            $.msg(ret);
          }
        }
      });
    });

    var src = $captcha.attr('src');
    function changeCaptcha () {
      $captcha.attr('src', src + '?t=' + new Date());
    }
  });
</script>
<?= $block->end() ?>