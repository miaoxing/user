<?php $view->layout() ?>

<form class="form" method="post" id="reset-password-form">
  <div class="form-legend">
    &nbsp
  </div>

  <div class="form-group">
    <label for="password" class="control-label">新密码</label>

    <div class="col-control">
      <input type="password" class="form-control" id="password" name="password" placeholder="请输入新密码">
    </div>
  </div>
  <div class="form-group">
    <label for="password-confirm" class="control-label"></label>

    <div class="col-control">
      <input type="password" class="form-control" id="password-confirm" name="passwordConfirm"
        placeholder="请再次输入密码">
    </div>
    <input type="hidden" name="userId" value="<?= $userId ?>">
  </div>
  <div class="form-footer">
    <button type="submit" class="btn btn-primary btn-block hairline">重置密码</button>
  </div>
</form>

<?= $block('js') ?>
<script>
  require(['jquery-form'], function () {
    var param = 'nonce=<?= $nonce ?>&timestamp=<?= $timestamp ?>&userId=<?= $userId ?>&sign=<?= $sign ?>';
    $('#reset-password-form').ajaxForm({
      url: $.url('password/reset-update?' + param),
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code > 0) {
            window.location = $.req('next') || $.url('users');
          }
        });
      }
    });
  });
</script>
<?= $block->end() ?>
