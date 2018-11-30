import React from "react";
import TableProvider from "components/TableProvider";
import Table from "components/Table";
import Actions from "components/Actions";
import CDeleteLink from "components/CDeleteLink";
import CEditLink from "components/CEditLink";
import CNewBtn from "components/CNewBtn";
import PageHeader from "components/bs4/PageHeader";
import {Button} from "react-bootstrap4";
import app from "app";

export default class extends React.Component {
  handleClick = (reload) => {
    app.post(app.url('admin/wechat-groups/sync-from-wechat'))
      .then(ret => $.msg(ret, () => reload()));
  };

  render() {
    window.app = app;

    return <>
      <TableProvider>
        {({reload}) => <>
          <PageHeader>
            <div className="float-right">
              {wei.hasWechatGroup && <Button variant="default" onClick={this.handleClick.bind(this, reload)}>
                从微信同步分组
              </Button>}
              {' '}
              <CNewBtn/>
            </div>
            {wei.page.controllerTitle}
          </PageHeader>

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
