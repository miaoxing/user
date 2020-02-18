import React from "react";
import {TableProvider} from "@miaoxing/table";
import CDeleteLink from "plugins/app/resources/components/CDeleteLink";
import CEditLink from "plugins/app/resources/components/CEditLink";
import CNewBtn from "plugins/app/resources/components/CNewBtn";
import {Button} from "react-bootstrap";
import app from 'plugins/app/resources/modules/app';
import {Page, PageActions} from "@miaoxing/page";
import {LinkActions} from "@miaoxing/actions";
import Table from "antdx-table";
import $ from '@miaoxing/app';

export default class extends React.Component {
  state = {};

  constructor(props) {
    super(props);
    this.ref = React.createRef();
  }

  componentDidMount() {
    $.get(app.url('admin-api/groups/metadata'), {loading: true}).then(ret => this.setState(ret));
  }

  handleClick = (api) => {
    $.post(app.url('admin/wechat-groups/sync-from-wechat'), {loading: true})
      .then(ret => $.ret(ret, api.reload));
  };

  render() {
    return <Page>
      <TableProvider>
        {api => <>
          <PageActions>
            {this.state.hasWechatGroup && <Button variant="secondary" onClick={this.handleClick.bind(this, api)}>
              从微信同步分组
            </Button>}
            <CNewBtn/>
          </PageActions>

          <Table
            search={true}
            url={app.curApiIndexUrl()}
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
                    <CDeleteLink id={id}/>
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
