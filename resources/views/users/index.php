<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/users.css') ?>">
<style>
  .list-indented > .list-divider + li {
    padding-right: 0;
  }
</style>
<?= $block->end() ?>

<?php require $view->getFile('@user/users/index-head.php') ?>

<?php $event->trigger('beforeUserIndexRenderMenu', [$nav]) ?>

<ul class="list list-indented">
  <?php $view->nav->displayLink($nav) ?>
</ul>
