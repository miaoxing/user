<?php

$view->layout('admin:admin/layout-light.php')
?>

<div class="page-header">
  <h1 class="page-title-light">
    注册
  </h1>
</div>
<!-- /.page-header -->

<div class="page-body row">
  <div class="col-xs-12">

    <form class="js-register-form" role="form" method="post" action="<?= $url('registration/create') ?>">

      <div class="form-group">
        <label for="email">
          邮箱
        </label>
        <input type="text" class="form-control" id="email" name="email">
      </div>

      <div class="form-group">
        <label for="password">
          密码
        </label>
        <input type="password" class="form-control" id="password" name="password">
      </div>

      <div class="form-group">
        <label for="password-confirm">
          确认密码
        </label>
        <input type="password" class="form-control" id="password-confirm" name="passwordConfirm">
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

      <?php if ($agreementArticleId) : ?>
        <div class="checkbox">
          <label>
            <input name="agreement" type="checkbox" value="1"> 同意<a class="js-agreement" href="javascript:">《服务协议》</a>
          </label>
        </div>
      <?php endif ?>

      <div class="clearfix form-group m-t-md">
        <button class="btn btn-primary btn-block btn-lg" type="submit">
          注册
        </button>
      </div>
    </form>

    <hr>
    <div class="m-t text-center">
      已有账号，点击<a href="<?= $url('admin/login') ?>">登录</a>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="js-agreement-modal modal fade" tabindex="-1" role="dialog" aria-labelledby="agreement-modal-label"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-bottom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="agreement-modal-label">服务协议</h4>
      </div>
      <div class="js-agreement-content modal-body">

      </div>
      <div class="modal-footer border-top">
        <button type="button" class="btn btn-default hairline" data-dismiss="modal">确认</button>
      </div>
    </div>
  </div>
</div>

<?= $block('js') ?>
<script>
  require(['form'], function (form) {
    $('.js-register-form').ajaxForm({
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (typeof ret.captchaErr != 'undefined' && ret.captchaErr === true) {
            changeCaptcha();
          }

          if (ret.code == 1) {
            window.location = $.url('registration/confirm');
          }
        });
      }
    });

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
