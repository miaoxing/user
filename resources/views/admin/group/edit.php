<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/group/index') ?>">返回列表</a>

  <h1>
    用户组管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      <?= $action == 'add' ? '添加' : '编辑' ?>用户组
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="record-form" class="form-horizontal" action="<?= $url('admin/group/' . ($group->isNew() ? 'create' : 'update')) ?>" method="post" role="form">
      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          <span class="text-warning">*</span>
          名称
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="name" id="name">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="isCustomerService">
          是否客服
        </label>

        <div class="col-lg-4">

          <label class="radio-inline">
            <input type="radio" name="isCustomerService" value="1"> 是
          </label>
          <label class="radio-inline">
            <input type="radio" name="isCustomerService" value="0"> 否
          </label>

        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label" for="sort">
          顺序
        </label>

        <div class="col-sm-4">
          <input type="text" class="form-control" name="sort" id="sort">
        </div>

        <label class="col-sm-6 help-text" for="sort">
          大的显示在前面,按从大到小排列.
        </label>
      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <input type="hidden" id="id" name="id">

          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>

          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/group/index') ?>">
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

<?= $block('js') ?>
<script>
  require(['form'], function () {
    $('#record-form')
      .loadJSON(<?= $group->toJson() ?>)
      .ajaxForm({
        dataType: 'json',
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/group/index');
            }
          });
        }
      });
  });
</script>
<?= $block->end() ?>
