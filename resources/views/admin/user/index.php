<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<!-- /.page-header -->
<div class="page-header">
  <div class="pull-right">
    <a class="btn btn-success" href="<?= $url('admin/user/new') ?>">添加用户</a>
  </div>
  <h1>
    用户管理
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <form class="js-user-form form-horizontal filter-form" role="form">
        <div class="well form-well m-b">
          <div class="form-group form-group-sm">
            <label class="col-md-1 control-label" for="is-valid">状态：</label>

            <div class="col-md-3">
              <select name="isValid" id="is-valid" class="form-control">
                <option value="" selected>全部状态</option>
                <option value="1">已关注</option>
                <option value="0">未关注</option>
              </select>
            </div>

            <label class="col-md-1 control-label" for="group-id">分组：</label>

            <div class="col-md-3">
              <select name="groupId" id="group-id" class="form-control">
                <option value="">全部分组</option>
                <option value="0"><?= $setting('user.titleDefaultGroup') ?: '未分组' ?></option>
              </select>
            </div>

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

          <div class="form-group form-group-sm">
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

          <div class="form-group form-group-sm">
            <?php $event->trigger('adminUserSearch') ?>
          </div>

          <div class="clearfix form-group form-group-sm">
            <div class="col-md-offset-1 col-md-6">
              <button class="js-user-filter btn btn-primary btn-sm" type="submit">
                查询
              </button>
              &nbsp;
              <a id="export-csv" class="js-export-csv btn btn-white btn-sm" href="javascript:void(0);">导出</a>
            </div>
          </div>
        </div>
      </form>

      <table id="record-table" class="record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th class="t-3"></th>
          <th>用户</th>
          <th class="t-4">姓名</th>
          <th class="t-4">手机</th>
          <th class="t-8">地区</th>
          <th class="t-3">积分</th>
          <th class="t-4">来源</th>
          <th class="t-3">是否关注</th>
          <th class="t-10">注册时间</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div class="well form-well">
        <form class="form-inline" role="form">
          <label>
            <input class="ace" type="checkbox" id="check-all">
            <span class="lbl"> 全选 </span>
          </label>

          <div class="form-group">
            <select id="to-group-id" class="form-control input-sm" disabled>
              <option>移动到分组</option>
              <option value="0"><?= $setting('user.titleDefaultGroup') ?: '未分组' ?></option>
            </select>
          </div>

          <?php if ($plugin->isInstalled('coupon')) : ?>
            <div class="form-group">
              <a id="user-send-coupon" class="btn btn-info pull-right" href="javascript:void(0);">发放优惠券</a>
            </div>
          <?php endif ?>

          <?php if ($plugin->isInstalled('score')) : ?>
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

<?php require $view->getFile('user:admin/user/richInfo.php') ?>

<?= $block('js') ?>
<script>
  require(['form', 'assets/admin/user', 'dataTable', 'template', 'jquery-deparam'], function (form) {
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
          render: function (data) {
            return '<label><input type="checkbox" class="ace" value="' + data + '"><span class="lbl"></span></label>'
          }
        },
        {
          data: 'nickName',
          sClass: 'user-media-td',
          render: function (data, type, full) {
            full.tip = full.group.name;
            return template.render('user-info-tpl', full);
          }
        },
        {
          data: 'name'
        },
        {
          data: 'mobile'
        },
        {
          data: 'country',
          render: function (data, type, full) {
            return full.country + ' ' + full.province + ' ' + full.city;
          }
        },
        {
          data: 'score',
          sClass: 'text-center'
        },
        {
          data: 'sourceUser',
          sClass: 'text-center',
          render: function (data, type, full) {
            if (full.source == '-1') {
              return '后台创建';
            }
            if (!data) {
              return '直接关注';
            }
            return template.render('user-info-tpl',data);
          }
        },
        {
          data: 'isValid',
          sClass: 'text-center',
          render: function (data, type, full) {
            return data == '1' ? '是' : '否';
          }

        },
        {
          data: 'createTime',
          sClass: 'text-center',
          render: function (data) {
            return data.substr(0, 16);
          }
        }
      ]
    });

    // 更改分组时,刷新列表
    $(document).on('group.changed', function () {
      recordTable.reload();
    });
  });
</script>
<?= $block->end() ?>
