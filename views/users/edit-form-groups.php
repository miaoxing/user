<?php if (!$hideMobile) : ?>
  <div class="js-form-group-mobile form-group-mobile form-group">
    <label for="mobile" class="control-label">
      手机号码
      <span class="text-warning">*</span>
    </label>

    <div class="col-control">
      <input type="tel" class="form-control" id="mobile" name="mobile"
        placeholder="请输入手机号码" <?= $isMobileVerified ? 'readonly' : '' ?>>
      <span class="mobile-verify-link">
        <?php if ($enableMobileVerify) : ?>
          <?php if ($isMobileVerified) : ?>
            <span class="text-muted">已认证</span>
          <?php else : ?>
            <a class="text-primary" href="<?= $url('user-mobile', ['next' => $req->getUrl()]) ?>">去认证</a>
          <?php endif; ?>
        <?php endif; ?>
      </span>
    </div>
  </div>
<?php endif; ?>

<?php require $view->getFile('@user/users/edit-form-groups-other.php'); ?>

