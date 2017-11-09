<?php $view->layout() ?>

<?= $block('header-actions') ?>
<a class="btn btn-white" id="sync-from-wechat">
  <i class="fa fa-refresh"></i> 从微信同步分组
</a>
<a class="btn btn-success" href="<?= $url('admin/groups/new') ?>">添加用户组</a>
<?= $block->end() ?>

<div class="row">
  <div class="col-xs-12">
    <!-- PAGE CONTENT BEGINS -->
    <div class="table-responsive">
      <table id="record-table" class="record-table table table-bordered table-hover">
        <thead>
        <tr>
          <th>名称</th>
          <th>顺序</th>
          <th>状态</th>
          <th>操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>

        </tfoot>
      </table>
    </div>
    <!-- /.table-responsive -->
    <!-- PAGE CONTENT ENDS -->
  </div>
</div>
<!-- /.row -->

<script id="table-actions" type="text/html">
  <div class="action-buttons">
    <a href="<%= $.url('admin/groups/%s/edit', id) %>" title="编辑">
      <i class="fa fa-edit bigger-130"></i>
    </a>

    <a class="text-danger delete-record" data-id="<%= id %>" title="删除" href="javascript:">
      <i class="fa fa-trash-o bigger-130"></i>
    </a>
  </div>
</script>

<?= $block('js') ?>
<script>
  require(['form', 'dataTable', 'jquery-deparam'], function () {
    var recordTable = $('#record-table').dataTable({
      ajax: {
        url: $.queryUrl('admin/groups.json')
      },
      columns: [
        {
          data: 'name'
        },
        {
          data: 'sort'
        },
        {
          data: 'wechatId',
          render: function (data, type, full) {
            if (data > 0) {
              return '已同步';
            }
            return '未同步';
          }
        },
        {
          data: 'id',
          render: function (data, type, full) {
            return template.render('table-actions', full)
          }
        }
      ]
    });

    // 点击删除链接
    recordTable.on('click', 'a.delete-record', function () {
      var $this = $(this);
      $.confirm('删除后将无法还原,确认删除?', function () {
        $.post($.url('admin/groups/destroy', {id: $this.data('id')}), function () {
          recordTable.fnDraw(false);
        }, 'json');
      });
    });

    $('#sync-from-wechat').click(function () {
      var icon = $(this).find('.fa-refresh');
      icon.addClass('fa-spin');
      $.ajax({
        url: $.url('admin/wechat-groups/sync-from-wechat'),
        dataType: 'json',
        success: function (result) {
          if (result.code > 0) {
            $.alert(result.message);
          } else {
            $.err(result.message);
          }
          recordTable.reload();
        },
        complete: function () {
          icon.removeClass('fa-spin');
        }
      });
    });
  });
</script>
<?= $block->end() ?>
