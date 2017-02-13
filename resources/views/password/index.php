<?php $view->layout() ?>

<form class="form" method="post" id="resetPasswordForm">
  <div class="form-legend text-right">
    <a href="<?= $url->query('password/reset') ?>">忘记旧密码?</a>
  </div>

  <div class="form-group">
    <label for="oldPassword" class="control-label">旧密码</label>

    <div class="col-control">
      <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="请输入旧密码" value="<?= $e($req['oldPassword']) ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="password" class="control-label">新密码</label>

    <div class="col-control">
      <input type="password" class="form-control" id="password" name="password" placeholder="请输入新密码">
    </div>
  </div>

  <div class="form-group">
    <label for="passwordConfirm" class="control-label"></label>

    <div class="col-control">
      <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm"
             placeholder="请再次输入密码">
    </div>
  </div>

  <div class="form-footer">
    <button type="submit" class="btn btn-primary btn-block">修改密码</button>
  </div>
</form>

<?= $block('js') ?>
<script>
  require(['jquery-form'], function () {
    $('#resetPasswordForm').ajaxForm({
      url: $.url('password/update'),
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
