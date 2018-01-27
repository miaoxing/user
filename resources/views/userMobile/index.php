<?php $view->layout() ?>

<form class="js-mobile-form form form-inset m-t" method="post" action="<?= $url->query('user-mobile/create') ?>">
  <div class="form-body">
    <div class="form-group">
      <label for="mobile" class="control-label">
        手机号码
        <span class="text-warning">*</span>
      </label>

      <div class="col-control">
        <input type="tel" class="js-mobile form-control" id="mobile" name="mobile" value="<?= $curUser['mobile'] ?>"
          placeholder="请输入手机号码">
      </div>
    </div>

    <div class="js-form-group-verify-code form-group hide">
      <label for="verify-code" class="control-label">
        验证码
        <span class="text-warning">*</span>
      </label>

      <div class="col-control">
        <div class="input-group">
          <input type="tel" class="form-control" id="verify-code" name="verifyCode" placeholder="请输入验证码">
          <span class="input-group-btn border-left">
            <button type="button" class="js-verify-code-send text-primary btn btn-default form-link">
              获取验证码
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="form-footer">
    <button type="button" class="js-mobile-check btn btn-primary btn-block">下一步</button>
    <button type="submit" class="js-mobile-submit btn btn-primary btn-block display-none">绑定</button>
  </div>
</form>

<?= $block->js() ?>
<script>
  require(['jquery-form', 'plugins/verify-code/js/verify-code'], function () {
    var $verifyCodeSend = $('.js-verify-code-send');

    // 检查手机号能否绑定
    $('.js-mobile-check').click(function () {
      $.ajax({
        dataType: 'json',
        url: $.url('user-mobile/check'),
        data: {
          mobile: $('.js-mobile').val()
        },
        success: function (ret) {
          if (ret.code !== 1) {
            $.msg(ret);
          } else {
            $('.js-form-group-verify-code').removeClass('hide');
            $('.js-mobile').prop('readonly', true);
            $('.js-mobile-check').hide();
            $('.js-mobile-submit').show();
            $verifyCodeSend.click();
          }
        }
      });
    });

    $('.js-mobile-form').ajaxForm({
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code == 1) {
            window.location = $.req('next') || $.url('users');
          }

          if (typeof ret.verifyCodeErr != 'undefined' && ret.verifyCodeErr) {
            $verifyCodeSend.verifyCode('reset');
          }
        });
      }
    });

    // 发送验证码
    $verifyCodeSend.verifyCode({
      url: $.url('users/send-verify-code')
    });
  });
</script>
<?= $block->end() ?>
