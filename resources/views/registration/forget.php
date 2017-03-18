<?php
$view->layout('admin:admin/layout-light.php')
?>

<div class="page-header">
  <h1 class="page-title-light">
    忘记密码
  </h1>
</div>
<!-- /.page-header -->

<div class="page-body row">
  <div class="col-xs-12">
    <form class="js-forget-form" role="form" method="post" action="<?= $url('registration/create-reset-by-email') ?>">
      <div class="form-group">
        <label for="email">
          邮箱
        </label>
        <input type="text" class="form-control" id="email" name="email">
      </div>

      <div class="form-group">
        <label for="captcha">
          验证码
        </label>
        <div class="input-group">
          <input type="text" class="form-control" id="captcha" name="captcha" placeholder="请输入验证码"
            data-rule-required="true">
            <span class="input-group-addon p-a-0">
              <img class="js-captcha" src="<?= $url('captcha') ?>">
            </span>
        </div>
      </div>

      <div class="clearfix form-group m-t-md">
        <button class="btn btn-primary btn-block btn-lg" type="submit">
          发送验证到邮箱
        </button>
      </div>
    </form>
    <hr>
    <div class="m-t text-center">
      已有账号，点击<a href="<?= $url('admin/login') ?>">登录</a>
    </div>
  </div>
</div>

<?= $block('js') ?>
<script>
  require(['form'], function (form) {
    $('.js-forget-form').ajaxForm({
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (typeof ret.captchaErr != 'undefined' && ret.captchaErr === true) {
            $captcha.attr('src', src + '?t=' + new Date());
          }

          if (ret.code == 1) {
            window.location = $.url('admin/login');
          }
        });
      }
    });

    var $captcha = $('.js-captcha');
    var src = $captcha.attr('src');
    $captcha.click(function() {
      $captcha.attr('src', src + '?t=' + new Date());
    });
  });
</script>
<?= $block->end() ?>
