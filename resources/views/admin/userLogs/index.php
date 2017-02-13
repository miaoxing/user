<?php $view->layout() ?>

<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<div class="page-header">
  <h1>
    用户日志
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="table-responsive">
      <form class="js-log-form form-horizontal filter-form" role="form">

        <div class="well form-well m-b">
          <div class="form-group form-group-sm">

            <label class="col-md-1 control-label" for="actionName">操作名称：</label>
            <div class="col-md-3">
              <input type="text" class="form-control" name="actionName" id="actionName">
            </div>

            <label class="col-md-1 control-label" for="confirm">确认状态：</label>
            <div class="col-md-3">
              <select id="confirm" name="confirm" class="form-control">
                <option value="">全部</option>
                <option value="1">已确认</option>
                <option value="0">未确认</option>
              </select>
            </div>

          </div>
        </div>
      </form>
      <table class="js-log-table record-table table table-striped table-bordered table-hover">
        <thead>
        <tr>
          <th>用户</th>
          <th>操作名称</th>
          <th>操作时间</th>
          <th>更改前</th>
          <th>更改后</th>
          <th>确认时间</th>
          <th style="width: 120px">操作</th>
        </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- PAGE detail ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<script id="tableActionsTpl" type="text/html">
  <% if (confirmUser == 0) { %>
  <button class="js-confirm btn btn-primary btn-sm" data-id="<%= id %>">确认</button>
  <% } else { %>
  -
  <% } %>
</script>

<?= $block('js') ?>
<script>
  require(['dataTable', 'jquery-deparam', 'form', 'daterangepicker'], function () {
    var $recordTable = $('.js-log-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/user-logs.json')
      },
      columns: [
        {
          data: 'user',
          render: function (data, type, full) {
            return full.userId == '0' ? '游客' : template.render('user-info-tpl', full.user);
          }
        },
        {
          data: 'action'
        },
        {
          data: 'createTime'
        },
        {
          data: 'oldValue',
          render: function (data, type, full) {
            return data || '-';
          }
        },
        {
          data: 'newValue',
          render: function (data, type, full) {
            return data || '-';
          }
        },
        {
          data: 'confirmTime',
          render: function (data, type, full) {
            return full.confirmUser == '0' ? '-' : data;
          }
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('tableActionsTpl', full);
          }
        }
      ]
    });

    $('.js-log-form').loadParams().update(function () {
      $recordTable.reload($(this).serialize(), false);
    });

    // 发放红包
    $recordTable.on('click', '.js-confirm', function () {
      var id = $(this).data('id');
      $.confirm('确认该操作?', function () {
        $.ajax({
          url: $.queryUrl('admin/user-logs/%s/confirm.json', id),
          dataType: 'json'
        }).done(function (ret) {
          $.msg(ret);
          $recordTable.reload();
        });
      });
    });
  });
</script>
<?= $block->end() ?>

<?php require $view->getFile('user:admin/user/richInfo.php') ?>
