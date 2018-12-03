import React from "react";
import TableProvider from "components/TableProvider";
import Table from "components/bs4/Table";
import Actions from "components/Actions";
import CDeleteLink from "components/CDeleteLink";
import CEditLink from "components/CEditLink";
import CNewBtn from "components/CNewBtn";
import PageHeader from "components/bs4/PageHeader";
import {Button} from "react-bootstrap4";
import app from "app";
import axios from 'axios';

export default class extends React.Component {
  handleClick = (api) => {
    axios.post(app.url('admin/wechat-groups/sync-from-wechat'), {}, {loading: true})
      .then(({data}) => app.ret(data, api.reload));
  };

  render() {
    return <>
      <TableProvider>
        {api => <>
          <PageHeader>
            <div className="float-right">
              {wei.hasWechatGroup && <Button variant="secondary" onClick={this.handleClick.bind(this, api)}>
                从微信同步分组
              </Button>}
              {' '}
              <CNewBtn/>
            </div>
            {wei.page.controllerTitle}
          </PageHeader>

          <Table
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
