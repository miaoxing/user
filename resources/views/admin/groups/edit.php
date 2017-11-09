<?php

$view->layout();

$wei->page->addActionJs('form');
?>

<?= $block('header-actions') ?>
<a class="btn btn-default" href="<?= $url('admin/groups') ?>">返回列表</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12" id="root"></div>
</div>
