<?php

$view->layout('admin:admin/layout.php')
?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/plugin/css/ret.css') ?>">
<?= $block->end() ?>

<div class="page-header">
  <h1>
    确认邮箱
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="ret ret-success">
      <div class="ret-icon-container">
        <i class="ret-icon ret-icon-success"></i>
      </div>
      <h2 class="ret-title">
        您已注册成功
      </h2>
      <p class="ret-detail">
        请登录您的邮箱,点击链接确认注册.
      </p>
      <div>
        <a class="js-resend-email btn btn-white" href="javascript:;">重新发送邮件</a>
        <a class="m-l btn btn-white" href="<?= $url('registration/edit-email') ?>">修改邮箱</a>
      </div>

    </div>
  </div>
</div>

<?= $block('js') ?>
  <script>
    $('.js-resend-email').click(function () {
      $.ajax({
        url: $.url('registration/resend-email'),
        dataType: 'json',
        success: function (ret) {
          $.msg(ret);
        }
      });
    });
  </script>
<?= $block->end() ?>
