<?php $view->layout() ?>

<div class="page-header">
  <h1>
    用户管理
    <small>
      <i class="fa fa-angle-double-right"></i>
      来源统计
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="well form-well">
      <form class="form-inline" id="search-form">
        <div class="form-group">
          &nbsp;&nbsp;
          <label class="control-label" for="startTime">时间范围</label>
          <input type="text" class="form-control text-center" id="startTime" name="startTime" style="width: 150px"
                 value="<?= $req['startTime'] ?>">
          ~
          <input type="text" class="form-control text-center" id="endTime" name="endTime" style="width: 150px"
                 value="<?= $req['endTime'] ?>">
        </div>
        <div class="form-group">
          <a class="btn btn-primary" id="ref-query" href="javascript:;">查询</a>
        </div>
        <a class="js-export-csv btn btn-white pull-right"  href="javascript:;">导出</a>
      </form>
    </div>

    <div class="table-responsive">
      <table id="record-table" class="js-user-ref-table record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>场景编号</th>
          <th>来源名称</th>
          <th>数量</th>
          <th style="width: 290px">所属用户</th>
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

<?= $block('js') ?>
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

    $('#startTime, #endTime').rangeDateTimePicker({
      showSecond: true,
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });

    $('#ref-query').click(function () {
      window.location.href = $.url('admin/user/ref?startTime=' + $('#startTime').val() + '&endTime=' + $('#endTime').val() + '&accountId=' + $('#accountId').val());
    });

    $('.js-export-csv').click(function () {
      window.location = $.appendUrl(recordTable.fnSettings().ajax.url, {page: 1, rows: 99999, _format: 'csv'});
    });
  });
</script>
<?= $block->end() ?>
