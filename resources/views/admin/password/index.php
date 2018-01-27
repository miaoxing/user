<?php $view->layout() ?>

<div class="page-header">
  <h1>
    修改密码
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form class="js-password-form form-horizontal" action="<?= $url('admin/password/update') ?>"
      method="post" role="form">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="old-password">
          <span class="text-warning">*</span>
          旧密码
        </label>

        <div class="col-lg-4">
          <input type="password" class="form-control" name="oldPassword" id="old-password">
        </div>

      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="password">
          <span class="text-warning">*</span>
          新密码
        </label>

        <div class="col-lg-4">
          <input type="password" class="form-control" name="password" id="password">
        </div>

      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="password-confirm">
          <span class="text-warning">*</span>
          重复密码
        </label>

        <div class="col-lg-4">
          <input type="password" class="form-control" name="passwordConfirm" id="password-confirm">
        </div>
      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">

          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/user/index') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>

    </form>
  </div>
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['form'], function (form) {
    $('.js-password-form')
      .ajaxForm({
        dataType: 'json',
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.location.reload();
            }
          });
        }
      });
  });
</script>
<?= $block->end() ?>

