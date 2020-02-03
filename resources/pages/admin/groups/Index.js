import React from "react";
import TableProvider from "components/TableProvider";
import CDeleteLink from "components/CDeleteLink";
import CEditLink from "components/CEditLink";
import CNewBtn from "components/CNewBtn";
import {Button} from "react-bootstrap";
import app from "app";
import axios from 'axios';
import PageActions from "components/PageActions";
import Page from "components/Page";
import TdActions from "components/TdActions";
import AntTable from 'components/AntTable';

export default class extends React.Component {
  state = {};

  constructor(props) {
    super(props);
    this.ref = React.createRef();
  }

  componentDidMount() {
    axios(app.url('admin-api/groups/metadata'), {loading: true}).then(({data}) => this.setState(data));
  }

  handleClick = (api) => {
    axios.post(app.url('admin/wechat-groups/sync-from-wechat'), {}, {loading: true})
      .then(({data}) => app.ret(data, api.reload));
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

          <AntTable
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
                  <TdActions>
                    <CEditLink id={id}/>
                    <CDeleteLink id={id}/>
                  </TdActions>
                )
              },
            ]}
          />
        </>}
      </TableProvider>
    </Page>;
  }
}
