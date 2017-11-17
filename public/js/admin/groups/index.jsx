import React from 'react';
import ReactDOM from 'react-dom';
import {Table, Button} from 'react-bootstrap';
import {Page, PageHeader, DataTable} from 'components';

import asyncForm from 'async-dep-form';
import jQueryForm from 'jquery-form';
import jQueryDeparam from 'jquery-deparam';
import dataTable from 'data-table';

const loader = Promise.all([jQueryDeparam, dataTable]);

class GroupIndex extends React.Component {
  componentDidMount() {
    loader.then(() => {
      var $table = $('.js-group-table').dataTable({
        ajax: {
          url: $.queryUrl('admin/groups.json')
        },
        columns: [
          {
            title: '名称',
            data: 'name'
          },
          {
            title: '顺序',
            data: 'sort'
          },
          {
            title: '状态',
            data: 'wechatId',
            render: function (data, type, full) {
              if (data > 0) {
                return '已同步';
              }
              return '未同步';
            }
          },
          {
            title: '操作',
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
      <Page>
        <PageHeader>
          <Button id="sync-from-wechat">
            <i className="fa fa-refresh" /> 从微信同步分组
          </Button>
          {' '}
          <Button bsStyle="success" href={$.url('admin/groups/new')}>添加用户组</Button>
        </PageHeader>
        <DataTable className="js-group-table" />
      </Page>
    )
  }
}

ReactDOM.render(
  <GroupIndex />,
  document.getElementById('root')
);
