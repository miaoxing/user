<?php $view->layout() ?>

<!-- /.page-header -->
<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-default" href="<?= $url('admin/user/index') ?>">返回列表</a>
  </div>

  <h1>
    用户管理
  </h1>
</div>

<div class="row">

  <div class="col-12">
    <!-- PAGE detail BEGINS -->
    <form class="js-user-form form-horizontal" method="post" role="form" action="<?= $url('admin/user/editUser') ?>">

      <div class="form-group">
        <label class="col-lg-2 control-label" for="name">
          姓名
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="name" id="name">
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="mobile">
          手机号码
        </label>

        <div class="col-lg-4">
          <input type="text" class="form-control" name="mobile" id="mobile">
        </div>

        <div class="col-lg-4 col-form-label">
          <div class="form-check">
            <input type="hidden" name="isMobileVerified" value="0" data-populate-ignore>
            <input class="form-check-input" type="checkbox" name="isMobileVerified" value="1" id="isMobileVerified">
            <label class="js-tips form-check-label" for="isMobileVerified" title="认证后可以使用手机号码登录">
              认证
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="country">
          地区
        </label>

        <div class="col-lg-4">
          <div class="form-row">
            <div class="col">
              <select class="js-cascading-item form-control" id="country" name="country">
              </select>
            </div>
            <div class="col">
              <select class="js-cascading-item form-control" id="province" name="province">
              </select>
            </div>
            <div class="col">
              <select class="js-cascading-item form-control" id="city" name="city">
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-form-label">
          <div class="form-check">
            <input type="hidden" name="isRegionLocked" value="0" data-populate-ignore>
            <input class="form-check-input" type="checkbox" name="isRegionLocked" value="1" id="isRegionLocked">
            <label class="js-tips form-check-label" for="isRegionLocked" title="锁定后,不会被同步为外部的地区,如微信的资料">
              锁定
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="address">
          地址
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" name="address" id="address" rows="2"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-lg-2 control-label" for="signature">
          简介
        </label>

        <div class="col-lg-4">
          <textarea class="form-control" name="signature" id="signature" rows="2"></textarea>
        </div>
      </div>

      <input type="hidden" name="id" id="id">

      <div class="clearfix form-actions form-group">
        <div class="offset-lg-2">
          <button class="btn btn-primary" type="submit">
            <i class="fa fa-check bigger-110"></i>
            提交
          </button>
          &nbsp; &nbsp; &nbsp;
          <a class="btn btn-default" href="<?= $url('admin/user/index') ?>">
            <i class="fa fa-undo bigger-110"></i>
            返回列表
          </a>
        </div>
      </div>

    </form>
  </div>
  <!-- PAGE detail ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?= $block->js() ?>
<script>
  require([
    'form',
    'ueditor',
    'comps/jquery-cascading/jquery-cascading',
    'plugins/app/libs/jquery.populate/jquery.populate'
  ], function () {
    var userInfo = <?= $user->toJSON() ?>;
    userInfo.isRegionLocked = <?= (int) $isRegionLocked ?>;
    userInfo.isMobileVerified = <?= (int) $isMobileVerified ?>;

    $('.js-cascading-item').cascading({
      url: $.url('regions.json'),
      valueKey: 'label',
      valueDataKey: 'value',
      values: [userInfo.country, userInfo.province, userInfo.city]
    });

    $('.js-user-form')
      .populate(userInfo)
      .ajaxForm({
        dataType: 'json',
        success: function (ret) {
          $.msg(ret, function () {
            if (ret.code === 1) {
              window.history.back();
            }
          });
        }
      });

    $('.js-tips').tooltip();
  });
</script>
<?= $block->end() ?>
