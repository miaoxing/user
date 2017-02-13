<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/users.css') ?>">
<?= $block->end() ?>

<div class="clearfix user-nav-actions">
  <a href="<?= $url->query('users/register') ?>">注册</a>
  &nbsp;
  <a href="<?= $url->query('password/reset') ?>">忘记密码?</a>
</div>

<form class="js-login-form form form-inset" method="post">
  <div class="form-body">
    <div class="form-group">
      <label for="username" class="control-label">账号</label>

      <div class="col-control">
        <input type="text" class="form-control" id="username" name="username" placeholder="手机/用户名/邮箱">
      </div>
    </div>
    <div class="form-group">
      <label for="password" class="control-label">密码</label>

      <div class="col-control">
        <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码">
      </div>
    </div>
  </div>
  <div class="form-footer">
    <button type="submit" class="btn btn-primary btn-block">登录</button>
  </div>
</form>

<?= $block('js') ?>
<script>
  require(['jquery-form'], function () {
    $('.js-login-form').ajaxForm({
      dataType: 'json',
      loading: true,
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            window.location = $.req('next') || $.url('users');
          }
        });
      }
    });
  });
</script>
<?= $block->end() ?>
