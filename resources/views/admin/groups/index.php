<?php

$view->layout();

$wei->page->addActionJs('index');
?>

<?= $block('header-actions') ?>
<a class="btn btn-white" id="sync-from-wechat">
  <i class="fa fa-refresh"></i> 从微信同步分组
</a>
<a class="btn btn-success" href="<?= $url('admin/groups/new') ?>">添加用户组</a>
<?= $block->end() ?>

<div id="root"></div>
