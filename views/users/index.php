<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/users.css') ?>">
<?= $block->end() ?>

<?php require $view->getFile('@user/users/index-head.php') ?>

<?php $event->trigger('beforeUserIndexRenderMenu', [$nav]) ?>

<?php $view->nav->displayLink($nav) ?>