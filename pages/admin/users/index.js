import React from 'react';
import {Table, TableProvider, useTable} from '@mxjs/a-table';
import {CEditLink} from '@mxjs/a-clink';
import {Page} from '@mxjs/a-page';
import {LinkActions} from '@mxjs/actions';

export default () => {
  const [table] = useTable();

  return (
    <Page>
      <TableProvider>
        <Table
          tableApi={table}
          columns={[
            {
              title: '头像',
              dataIndex: 'avatar',
              render: avatar => <img src={avatar} width={48} height={48}/>,
            },
            {
              title: '姓名',
              dataIndex: 'name',
            },
            {
              title: '昵称',
              dataIndex: 'nickName',
            },
            {
              title: '性别',
              dataIndex: 'sex',
              render: sex => sex === 1 ? '男' : '女',
            },
            {
              title: '手机',
              dataIndex: 'mobile',
            },
            {
              title: '地区',
              dataIndex: 'country',
              render: (id, row) => [row.country, row.province, row.city].filter(el => el).join(' ') || '-',
            },
            {
              title: '加入时间',
              dataIndex: 'createdAt',
              width: 180,
            },
            {
              title: '操作',
              dataIndex: 'id',
              render: (id) => (
                <LinkActions>
                  <CEditLink id={id}/>
                </LinkActions>
              ),
            },
          ]}
        />
      </TableProvider>
    </Page>
  );
};
