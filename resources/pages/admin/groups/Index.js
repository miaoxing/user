import React from "react";
import TableProvider from "components/TableProvider";
import Table from "components/Table";
import Actions from "components/Actions";
import CDeleteLink from "components/CDeleteLink";
import CEditLink from "components/CEditLink";
import CNewBtn from "components/CNewBtn";
import PageHeader from "components/PageHeader";
import {Button} from "react-bootstrap";
import app from "app";
import axios from 'axios';

export default class extends React.Component {
  state = {};

  componentDidMount() {
    axios(app.actionUrl('metadata'), {loading: true}).then(({data}) => this.setState(data));
  }

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
              {this.state.hasWechatGroup && <Button variant="secondary" onClick={this.handleClick.bind(this, api)}>
                从微信同步分组
              </Button>}
              {' '}
              <CNewBtn/>
            </div>
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
                hidden: !this.state.hasWechatGroup,
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
