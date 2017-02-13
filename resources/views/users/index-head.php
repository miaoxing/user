<div class="user-head">
  <img class="user-head-bg" src="<?= $bgImage ?: $asset('plugins/user/images/background.jpg') ?>">
  <div class="user-head-content flex flex-y flex-center">
    <!-- htmllint attr-bans="false" -->
    <span class="user-head-img" style="background-image:url('<?= $curUser->getHeadImg() ?>')"></span>
    <!-- htmllint attr-bans="$previous" -->
    <p class="user-head-nickname"><?= $curUser->getNickName() ?></p>
  </div>
  <?php if (!wei()->ua->isWeChat()) : ?>
    <a href="<?= $url('users/setting') ?>" class="user-setting">设置</a>
    <?php endif ?>
</div>
