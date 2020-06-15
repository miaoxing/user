/* eslint-disable */
define([], function () {
  $('#export-csv').click(function () {
    var dt = $('#record-table').dataTable();
    window.location = $.appendUrl(dt.fnSettings().ajax.url, {page: 1, rows: 99999, _format: 'csv'});
  });

  $('#check-all').click(function () {
    $('#record-table tbody input:checkbox').prop('checked', $(this).is(':checked'));
  });

  $('.table-responsive').on('click', 'input:checkbox', function () {
    $('#to-group-id').prop('disabled', !$('.table-responsive input:checkbox:checked').length);
  });

  // 批量分组
  $('#to-group-id').change(function () {
    var ids = $('#record-table input:checkbox:checked').map(function () {
      return $(this).val();
    }).get();

    $.post($.url('admin/user/moveGroup'), {groupId: $(this).val(), ids: ids}, function (result) {
      $.msg(result,function(){
        window.location.reload();
      });
    }, 'json');
  });

  // 赠送积分
  $('#user-send-score').click(function () {
    var ids = $('#record-table input:checkbox:checked').map(function () {
      return $(this).val();
    }).get();
    if (ids == '') {
      //alert('请选择用户');return;
    }
    window.location.href = $.url('admin/score/index?userlist=' + ids);
  });
});
