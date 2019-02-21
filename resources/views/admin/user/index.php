<?php

$view->layout();
$hasUserTag = wei()->plugin->isInstalled('user-tag');
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<!-- /.page-header -->
<div class="page-header">
  <div class="pull-right">
    <?php if (wei()->setting('user.enableNew')) : ?>
      <a class="btn btn-success" href="<?= $url('admin/user/new') ?>">添加用户</a>
    <?php endif ?>
  </div>
  <h1>
    用户管理
  </h1>
</div>

<div class="row">
  <div class="col-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="js-user-form form-horizontal filter-form" role="form">
        <div class="well">
          <div class="form-group">
            <label class="col-md-1 control-label" for="is-valid">状态：</label>

            <div class="col-md-3">
              <select name="isValid" id="is-valid" class="form-control">
                <option value="" selected>全部状态</option>
                <option value="1">已关注</option>
                <option value="0">未关注</option>
              </select>
            </div>

            <?php if ($hasUserTag) { ?>
                <label class="col-md-1 control-label" for="tag-ids">标签：</label>

                <div class="col-md-3">
                  <input type="text" class="js-tag-ids form-control" name="tagIds" id="tag-ids">
                </div>
            <?php } else { ?>
              <label class="col-md-1 control-label" for="group-id">分组：</label>

              <div class="col-md-3">
                <select name="groupId" id="group-id" class="form-control">
                  <option value="">全部分组</option>
                  <option value="0"><?= $setting('user.titleDefaultGroup') ?: '未分组' ?></option>
                </select>
              </div>
            <?php } ?>

            <label class="col-md-1 control-label" for="platform">来源：</label>

            <div class="col-md-3">
              <select name="platform" id="platform" class="form-control">
                <option value="">全部来源</option>
                <?php foreach ($platforms as $platform) : ?>
                  <option value="<?= $platform['value'] ?>"><?= $platform['name'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-1 control-label" for="nick-name">昵称：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="nick-name" name="nickName">
            </div>

            <label class="col-md-1 control-label" for="name">姓名：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="name" name="name">
            </div>

            <label class="col-md-1 control-label" for="mobile">手机号：</label>

            <div class="col-md-3">
              <input type="text" class="form-control" id="mobile" name="mobile">
            </div>
          </div>

          <div class="form-group">
            <?php $event->trigger('adminUserSearch') ?>
          </div>

          <div class="clearfix form-group">
            <div class="offset-md-1 col-md-6">
              <button class="js-user-filter btn btn-primary btn-sm" type="submit">
                查询
              </button>
              &nbsp;
              <?php if (wei()->setting('user.enableExport')) : ?>
                <a id="export-csv" class="js-export-csv btn btn-default btn-sm" href="javascript:void(0);">导出</a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </form>

      <table id="record-table" class="record-table table table-bordered table-hover"></table>
      <div class="well">
        <form class="form-inline" role="form">
          <label>
            <input class="ace" type="checkbox" id="check-all">
            <span class="lbl"> 全选 </span>
          </label>

          <?php if ($hasUserTag) { ?>
            <div class="form-group" style="width: 160px">
              <input type="text" class="js-to-tag-ids form-control" name="toTagIds" id="to-tag-ids"
                placeholder="请选择标签">
            </div>
            <div class="form-group">
              <button type="button" class="js-to-tag btn btn-info">打标签</button>
            </div>
          <?php } else { ?>
            <div class="form-group">
              <select id="to-group-id" class="form-control" disabled>
                <option>移动到分组</option>
                <option value="0"><?= $setting('user.titleDefaultGroup') ?: '未分组' ?></option>
              </select>
            </div>
          <?php } ?>

          <?php if ($wei->plugin->isInstalled('coupon')) : ?>
            <div class="form-group">
              <a class="js-user-send-coupon btn btn-info pull-right" href="javascript:void(0);">发放优惠券</a>
            </div>
          <?php endif ?>

          <?php if ($wei->plugin->isInstalled('score')) : ?>
            <div class="form-group">
              <a id="user-send-score" class="btn btn-info pull-right" href="javascript:void(0);">赠送积分</a>
            </div>
          <?php endif ?>
        </form>
      </div>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
  <!-- /col -->
</div>
<!-- /row -->

<?php require $view->getFile('@user/admin/user/richInfo.php') ?>

<?= $block->js() ?>
<script>
  require(['form', 'plugins/user/js/admin/users', 'plugins/admin/js/data-table', 'template', 'jquery-unparam',
    'comps/select2/select2.min',
    'css!comps/select2/select2',
    'css!comps/select2-bootstrap-css/select2-bootstrap'
  ], function (form) {
    form.toOptions($('#group-id'), <?= json_encode(wei()->group()->desc('sort')->fetchAll()) ?>, 'id', 'name');
    form.toOptions($('#to-group-id'), <?= json_encode(wei()->group()->desc('sort')->fetchAll()) ?>, 'id', 'name');

    $('.js-user-form')
      .loadParams()
      .submit(function (e) {
        recordTable.reload($(this).serialize(), false);
        e.preventDefault();
      });

    var recordTable = $('#record-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/user?_format=json')
      },
      columns: [
        {
          data: 'id',
          sClass: 't-2',
          render: function (data) {
            return '<label><input type="checkbox" class="ace" value="' + data + '"><span class="lbl"></span></label>'
          }
        },
        {
          title: '用户',
          data: 'nickName',
          sClass: 'user-media-td',
          render: function (data, type, full) {
            <?php if ($hasUserTag) { ?>
            var tips = [];
            for (var i in full.tags) {
              full.tags[i] && tips.push(full.tags[i].name);
            }
            full.tip = tips.join(' ');
            <?php } else { ?>
            full.tip = full.group.name;
            <?php } ?>
            return template.render('user-info-tpl', full);
          }
        },
        {
          title: '姓名',
          sClass: 't-4',
          data: 'name'
        },
        {
          title: '手机',
          sClass: 't-7',
          data: 'mobile'
        },
        {
          title: '地区',
          sClass: 't-8',
          data: 'country',
          render: function (data, type, full) {
            return full.country + ' ' + full.province + ' ' + full.city;
          }
        },
        {
          title: '积分',
          data: 'score',
          sClass: 't-3 text-center'
        },
        {
          title: '来源',
          data: 'sourceUser',
          sClass: 't-4 text-center',
          render: function (data, type, full) {
            if (data !== '') {
              return template.render('user-info-tpl', data);
            } else if (full.wechat_qrcode) {
              return full.wechat_qrcode.name;
            } else if (full.source == '-1') {
              return '后台创建';
            } else {
              return full.source == '' ? '-' : full.source;
            }
          }
        },
        {
          title: '关注',
          data: 'isValid',
          sClass: 't-3 text-center',
          render: function (data, type, full) {
            return data == '1' ? '是' : '否';
          }
        },
        {
          title: '关注时间',
          data: 'regTime',
          sClass: 't-8 text-center',
          render: function (data) {
            return data === '0000-00-00 00:00:00' ? '-' : data.substr(0, 16);
          }
        },
        <?php $event->trigger('adminUsersColumns') ?>
      ]
    });

    // 更改分组时,刷新列表
    $(document).on('group.changed', function () {
      recordTable.reload();
    });

    $('.js-tag-ids').select2({
      multiple: true,
      closeOnSelect: false,
      data: <?= json_encode($tags) ?>
    });

    var $toTagIds = $('.js-to-tag-ids').select2({
      multiple: true,
      closeOnSelect: false,
      data: <?= json_encode($tags) ?>
    });

    $('.js-to-tag').click(function () {
      var userIds = $('#record-table input:checkbox:checked').map(function () {
        return $(this).val();
      }).get();
      if (!userIds.length) {
        return $.err('请选择用户');
      }

      var tagIds = $toTagIds.select2('val');
      if (!tagIds.length) {
        return $.err('请选择标签');
      }

      $.ajax({
        url: $.url('admin/user-tags/update-users-tags'),
        dataType: 'json',
        type: 'post',
        data: {
          userIds: userIds,
          tagIds: tagIds,
        }
      }).then(function (ret) {
        $.msg(ret);
        if (ret.code === 1) {
          $.clearPopoverAsyncCache();
          recordTable.reload();
        }
      });
    });

    // 发放优惠券
    $('.js-user-send-coupon').click(function () {
      var ids = $('#record-table input:checkbox:checked').map(function () {
        return $(this).val();
      }).get();
      if (ids == '') {
        alert('请选择用户');
        return;
      }
      window.location.href = $.url('admin/coupons?userlist=' + ids);
    });
  });
</script>
<?= $block->end() ?>
