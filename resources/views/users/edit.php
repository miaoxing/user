<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/users.css') ?>">
<?= $block->end() ?>

<form class="js-user-form user-form form" method="post">
  <?php require $view->getFile('@user/users/edit-form-groups.php') ?>

  <div class="form-footer">
    <button type="submit" class="btn btn-primary btn-block">提 交</button>
  </div>
</form>

<?= $block->js() ?>
<script>
  require(['plugins/app/libs/jquery-form/jquery.form', 'comps/jquery.loadJSON/index'], function () {
    $('.js-user-form')
      .loadJSON(<?= $curUser->toJson(['name', 'mobile', 'address']) ?>)
      .ajaxForm({
        url: $.url('user/reg'),
        type: 'post',
        loading: true,
        dataType: 'json',
        success: function (ret) {
          $.msg(ret, function () {
            if ($.req('next')) {
              window.location = $.req('next');
            }
          });
        }
      });
  });
</script>
<?= $block->end() ?>
