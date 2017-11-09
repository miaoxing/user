<?php

$view->layout();

$wei->page->addActionJs('form');
?>

<div class="page-header">
  <a class="btn btn-default pull-right" href="<?= $url('admin/groups') ?>">返回列表</a>
  <h1>
    分组管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      <?= $action == 'add' ? '添加' : '编辑' ?>用户组
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-xs-12" id="root"></div>
</div>
