<?php $view->layout() ?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/group/index') ?>">返回列表</a>
  <h1>
    分组管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      <?= $action == 'add' ? '添加' : '编辑' ?>用户组
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-xs-12" id="root">
  </div>
</div>

<?= $block('js') ?>
<script src="<?= $wei->wpAsset('manifest.js') ?>"></script>
<script src="<?= $wei->wpAsset('react.js') ?>"></script>
<script src="<?= $wei->wpAsset('js/admin/groups/form.js') ?>"></script>
<?= $block->end() ?>
