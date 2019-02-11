<?php $view->layout() ?>

<div class="page-header">
  <h1>
    修改密码
  </h1>
</div>

<div class="row">
  <div class="col-12">
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
        <div class="offset-lg-2">

          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
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

