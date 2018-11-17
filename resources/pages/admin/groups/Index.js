import React from "react";
import {Button, PageHeader} from "react-bootstrap";
import TableProvider from "components/TableProvider";
import Table from "components/Table";
import Actions from "components/Actions";
import CDeleteLink from "components/CDeleteLink";
import CEditLink from "components/CEditLink";
import CNewBtn from "components/CNewBtn";

export default class extends React.Component {
  componentDidMount() {
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
  }

  render() {
    return <>
      <PageHeader>
        <div className="float-right">
          {wei.hasWechatGroup && <Button id="sync-from-wechat">
            <i className="fa fa-refresh"/> 从微信同步分组
          </Button>}
          {' '}
          <CNewBtn/>
        </div>
        {wei.page.controllerTitle}
      </PageHeader>

      <TableProvider>
        {({reload}) => <>
          <Table
            bootstrap4
            columns={[
              {
                text: '名称',
                dataField: 'name'
              },
              {
                text: '顺序',
                dataField: 'sort',
                sort: true
              },
              {
                text: '状态',
                dataField: 'wechatId',
                hidden: wei.hasWechatGroup,
                formatter: (cell) => cell > 0 ? '已同步' : '未同步',
              },
              {
                text: '操作',
                formatter: (cell, row) => <Actions>
                  <CEditLink id={row.id}/>
                  <CDeleteLink id={row.id}/>
                </Actions>
              },
            ]}
          />
        </>}
      </TableProvider>
    </>;
  }
}
