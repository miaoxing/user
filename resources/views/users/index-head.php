<div class="user-head">
  <img class="user-head-bg" src="<?= $asset->thumb($bgImage ?: $asset('plugins/user/images/background.jpg'), 750) ?>">
  <div class="user-head-content d-flex flex-column flex-center">
    <!-- htmllint attr-bans="false" -->
    <span class="user-head-img" style="background-image:url('<?= $curUser->getHeadImg() ?>')"></span>
    <!-- htmllint attr-bans="$previous" -->
    <p class="user-head-nickname"><?= $curUser->getNickName() ?></p>
    <?php $wei->event->trigger('userIndexRenderHead') ?>
  </div>
  <?php if (!wei()->ua->isWeChat()) : ?>
    <a href="<?= $url('users/setting') ?>" class="user-setting">设置</a>
  <?php endif ?>
</div>
