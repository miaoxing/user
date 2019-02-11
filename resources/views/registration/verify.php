<?php

$view->layout('@admin/admin/layout.php');
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/plugin/css/ret.css') ?>">
<?= $block->end() ?>

<div class="page-header">
  <h1>
    确认注册
  </h1>
</div>
<!-- /.page-header -->

<div class="row">
  <div class="col-12">
    <div class="ret ret-success">
      <div class="ret-icon-container">
        <i class="ret-icon ret-icon-success"></i>
      </div>
      <h2 class="ret-title">
        恭喜您完成注册
      </h2>
      <div>
        <a class="btn btn-default" href="<?= $url('admin') ?>"><?= $setting('user.registerSucBtnLabel', '进入页面') ?></a>
      </div>
    </div>
  </div>
</div>
