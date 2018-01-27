<?php $view->layout() ?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/admin/css/filter.css') ?>"/>
<?= $block->end() ?>

<div class="page-header">
  <h1>
    来源统计
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="table-responsive">
      <form class="form-horizontal filter-form form-inline" id="search-form">
        <div class="well form-well">
          <div class="form-group">
            <label class="control-label" for="start-time">时间范围：</label>

            <input type="text" class="form-control text-center input-small" id="start-time" name="startTime"
              value="<?= $req['startTime'] ?>">
            ~
            <input type="text" class="form-control text-center input-small" id="end-time" name="endTime"
              value="<?= $req['endTime'] ?>">
          <button class="btn btn-primary" type="button" id="ref-query">查询</button>
          <button class="js-export-csv btn btn-white" type="button">导出</button>
          </div>
        </div>
      </form>

      <table id="record-table" class="js-user-ref-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>场景编号</th>
          <th>来源名称</th>
          <th>数量</th>
          <th class="t-12">所属用户</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
  <!-- PAGE detail ENDS -->
</div><!-- /.col -->
<!-- /.row -->

<?php require $view->getFile('user:admin/user/richInfo.php') ?>

<?= $block->js() ?>
<script>
  require(['assets/dateTimePicker', 'dataTable', 'template', 'jquery-deparam', 'form'], function () {
    var recordTable = $('.js-user-ref-table').dataTable({
      dom: "t<'row'<'col-sm-12'ir>>",
      displayLength: 99999,
      ajax: {
        url: $.queryUrl('admin/user/ref?_format=json')
      },
      columns: [
        {
          data: 'id',
          render: function (data, type, full) {
            return data == '0' ? '-' : data;
          }
        },
        {
          data: 'name'
        },
        {
          data: 'count',
          bSortable: true
        },
        {
          data: 'user',
          render: function (data, type, full) {
            if (data) {
              return template.render('user-info-tpl', data);
            } else {
              return '-';
            }
          }
        }
      ]
    });

    $('#start-time, #end-time').rangeDateTimePicker({
      showSecond: true,
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });

    $('#ref-query').click(function () {
      window.location.href = $.url('admin/user/ref?startTime=' + $('#start-time').val() + '&endTime='
      + $('#end-time').val() + '&accountId=' + $('#accountId').val());
    });

    $('.js-export-csv').click(function () {
      window.location = $.appendUrl(recordTable.fnSettings().ajax.url, {page: 1, rows: 99999, _format: 'csv'});
    });
  });
</script>
<?= $block->end() ?>
