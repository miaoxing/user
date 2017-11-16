import React from 'react';
import ReactDOM from 'react-dom';
import {Table} from 'react-bootstrap';

import asyncForm from 'async-dep-form';
import jQueryForm from 'jquery-form';
import jQueryDeparam from 'jquery-deparam';
import dataTable from 'data-table';

class GroupIndex extends React.Component {
  componentDidMount() {
    Promise.all([asyncForm, jQueryForm, jQueryDeparam, dataTable]).then(() => {
      var $table = $('.js-group-table').dataTable({
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
            createdCell: (td, val) => {
              ReactDOM.render(<span>
                <a href={$.url('admin/groups/%s/edit', val)}>
                  编辑
                </a>
                {' '}
                <a className="text-danger delete-record" href="javascript:"
                  data-href={$.url('admin/groups/%s/destroy', val)}>
                  删除
                </a>
              </span>, td);
            }
          }
        ]
      });

      $table.deletable();

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
            $table.reload();
          },
          complete: function () {
            icon.removeClass('fa-spin');
          }
        });
      });
    });
  }

  render() {
    return (
      <div className="table-responsive">
        <Table bordered hover className="js-group-table table-center">
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
        </Table>
      </div>
    )
  }
}

ReactDOM.render(
  <GroupIndex />,
  document.getElementById('root')
);
