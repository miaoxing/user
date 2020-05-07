import React from "react";
import {Table, TableProvider, TableDeleteLink} from "@miaoxing/table";
import {CEditLink, CNewBtn} from "@miaoxing/clink";
import {Button} from "react-bootstrap";
import {Page, PageActions} from "@miaoxing/page";
import {LinkActions} from "@miaoxing/actions";
import $ from 'miaoxing';
import api from '@miaoxing/api';
import curUrl from '@miaoxing/cur-url';

export default class extends React.Component {
  state = {};

  constructor(props) {
    super(props);
    this.ref = React.createRef();
  }

  componentDidMount() {
    api.curPath('metadata', {loading: true}).then(ret => this.setState(ret));
  }

  handleClick = (tableApi) => {
    api.post('wechat-groups/sync-form-wechat', {loading: true}).then(ret => $.ret(ret, tableApi.reload));
  };

  render() {
    return <Page>
      <TableProvider>
        {tableApi => <>
          <PageActions>
            {this.state.hasWechatGroup && <Button variant="secondary" onClick={this.handleClick.bind(this, tableApi)}>
              从微信同步分组
            </Button>}
            <CNewBtn/>
          </PageActions>

          <Table
            columns={[
              {
                title: '名称',
                dataIndex: 'name'
              },
              {
                title: '顺序',
                dataIndex: 'sort',
                sorter: true,
              },
              {
                title: '状态',
                dataIndex: 'wechatId',
                hideInTable: !this.state.hasWechatGroup,
                render: text => text > 0 ? '已同步' : '未同步',
              },
              {
                title: '操作',
                dataIndex: 'id',
                render: (id) => (
                  <LinkActions>
                    <CEditLink id={id}/>
                    <TableDeleteLink href={curUrl.apiDestroy(id)}/>
                  </LinkActions>
                )
              },
            ]}
          />
        </>}
      </TableProvider>
    </Page>;
  }
}
