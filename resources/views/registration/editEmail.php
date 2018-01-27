<?php

$view->layout('admin:admin/layout.php')
?>

<div class="page-header">
  <h1>
    修改邮箱
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">

    <form class="form-horizontal js-email-form" role="form" method="post"
      action="<?= $url('registration/update-email') ?>">

      <div class="form-group">
        <label class="col-sm-2 control-label">
          原邮箱
        </label>

        <div class="col-sm-4">
          <p class="form-control-static"><?= $e($curUser['email']) ?: '-' ?></p>
        </div>
      </div>

      <div class="form-group">
        <label for="email" class="col-sm-2 control-label">
          <span class="text-warning">*</span>
          新邮箱
        </label>

        <div class="col-sm-4">
          <input type="text" class="form-control" id="email" name="email" placeholder="请输入您的新邮箱">
        </div>
      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $block->js() ?>
<script>
  require(['form'], function (form) {
    $('.js-email-form').ajaxForm({
      loading: true,
      dataType: 'json',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            window.location = $.url('registration/confirm');
          }
        });
      }
    });
  });
</script>
<?= $block->end() ?>
