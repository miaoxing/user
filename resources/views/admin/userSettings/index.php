<?php $view->layout() ?>

<div class="page-header">
  <h1>
    功能设置
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <form action="<?= $url('admin/user-settings/update') ?>" class="js-setting-form form-horizontal" method="post"
      role="form">
      <div class="form-group">
        <label class="col-lg-2 control-label" for="bg-image">
          个人中心背景图
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-bg-image form-control" id="bg-image" name="settings[user.bgImage]"
            value="<?= $e($bgImage) ?>">
        </div>

        <label class="col-lg-6 help-text" for="bg-image">
          推荐尺寸640*240，留空使用默认图片
        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="default-head-img">
          用户默认头像
        </label>

        <div class="col-lg-4">
          <input type="text" class="js-default-head-img form-control" id="bg-image" name="settings[user.defaultHeadImg]"
            value="<?= $e($defaultHeadImg) ?>">
        </div>

        <label class="col-lg-6 help-text" for="bg-image">
          比例1:1，留空使用默认图片
        </label>
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
  <!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require(['form', 'ueditor', 'validator', 'plugins/admin/js/image-upload'], function () {
    $('.js-setting-form')
      .ajaxForm({
        dataType: 'json',
        beforeSubmit: function(arr, $form, options) {
          return $form.valid();
        },
        success: function (ret) {
          $.msg(ret);
        }
      })
      .validate();

    $('.js-bg-image').imageUpload();
    $('.js-default-head-img').imageUpload();
  });
</script>
<?= $block->end() ?>
