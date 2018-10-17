<?php
$view->layout('@admin/admin/layout-light.php')
?>

<div class="page-header">
  <h1 class="page-title-light">
    忘记密码
  </h1>
</div>
<!-- /.page-header -->

<div class="page-body row">
  <div class="col-xs-12">
    <form class="js-forget-form" role="form" method="post">
      <div class="form-group">
        <label for="password">
          新密码
        </label>
        <input type="text" class="form-control" id="password" name="password">
      </div>

      <div class="form-group">
        <label for="password-confirm">
          重复密码
        </label>
        <input type="text" class="form-control" id="password-confirm" name="passwordConfirm">
      </div>

      <div class="clearfix form-group m-t-md">
        <input type="hidden" name="userId" value="<?= $userId ?>">
        <button class="btn btn-primary btn-block btn-lg" type="submit">
          提交
        </button>
      </div>
    </form>
  </div>
</div>

<?= $block->js() ?>
<script>
  require(['form'], function (form) {
    var param = 'nonce=<?= $nonce ?>&timestamp=<?= $timestamp ?>&userId=<?= $userId ?>&sign=<?= $sign ?>';
    $('.js-forget-form').ajaxForm({
      url: $.url('registration/reset-update?' + param),
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code > 0) {
            window.location = $.url('admin/login');
          }
        });
      }
    });
  });
</script>
<?= $block->end() ?>
