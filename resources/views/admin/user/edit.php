<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/user/index') ?>">返回列表</a>

  <h1>
    用户管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      <?= $user->isNew() ? '添加' : '编辑' ?>用户
    </small>
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <form id="record-form" class="form-horizontal" action="<?= $url('admin/user/' . ($user->getFormAction())) ?>"
      method="post" role="form">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="username">
          <span class="text-warning">*</span>
          用户名
        </label>

        <div class="col-lg-4">
          <?php if ($user->isNew()) : ?>
            <input type="text" class="form-control" name="username">
          <?php else : ?>
            <p class="form-control-static" id="username"></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="group-id">
          <span class="text-warning">*</span>
          用户组
        </label>

        <div class="col-lg-4">
          <select id="group-id" name="groupId" class="form-control">
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="nickname">
          <span class="text-warning">*</span>
          昵称
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="nickname" id="nickname">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="password">
          <span class="text-warning">*</span>
          密码
        </label>

        <div class="col-lg-4">
          <input type="password" class="form-control" name="password" id="password">
        </div>

        <?php if (!$user->isNew()) : ?>
          <label class="col-sm-6 help-text" for="password">
            不修改密码请留空
          </label>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="password-again">
          <span class="text-warning">*</span>
          重复密码
        </label>

        <div class="col-lg-4">
          <input type="password" class="form-control" name="passwordAgain" id="password-again">
        </div>
      </div>

      <div class="clearfix form-actions form-group">
        <div class="col-lg-offset-2">
          <input type="hidden" id="id" name="id">

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
    form.toOptions($('#group-id'), <?= json_encode(wei()->group()->desc('sort')->fetchAll()) ?>, 'id', 'name');

    $('#record-form')
      .loadJSON(<?= $user->toJson() ?>)
      .ajaxForm({
        dataType: 'json',
        success: function (result) {
          $.msg(result, function () {
            if (result.code > 0) {
              window.location = $.url('admin/user/index');
            }
          });
        }
      });
  });
</script>
<?= $block->end() ?>
