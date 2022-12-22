import {Table, TableProvider, useTable} from '@mxjs/a-table';
import {CEditLink} from '@mxjs/a-clink';
import {Page} from '@mxjs/a-page';
import {LinkActions} from '@mxjs/actions';
import {SearchForm, SearchItem} from '@mxjs/a-form';
import RegionCascader from '@mxjs/a-region-cascader';
import DateRangePicker from '@mxjs/a-date-range-picker';
import {UserMedia} from '@miaoxing/user/admin';
import {CheckCircleTwoTone} from '@ant-design/icons';
import {Box} from '@mxjs/box';
import {Select} from '@miaoxing/admin';
import {useState} from 'react';

const Index = () => {
  const [table] = useTable();

  const [sexes, setSexes] = useState([]);
  const handleAfterLoadSexes = ({data}) => {
    setSexes(data.items);
  };

  return (
    <Page>
      <TableProvider>
        <SearchForm>
          <SearchItem label="姓名" name={['search', 'name:ct']}/>

          <SearchItem label="昵称" name={['search', 'nickName:ct']}/>

          <SearchItem label="性别" name={['search', 'sex']} initialValue="">
            <Select url="consts/sexConst-sex" all labelKey="name" valueKey="id"
              afterLoad={handleAfterLoadSexes}/>
          </SearchItem>

          <SearchItem label="手机" name={['search', 'mobile:ct']}/>

          <SearchItem label="地区" name="regions">
            <RegionCascader names={[['search', 'country'], ['search', 'province'], ['search', 'city']]}/>
          </SearchItem>

          <SearchItem label="加入时间" name="_createdAt">
            <DateRangePicker names={[['search', 'createdAt:ge'], ['search', 'createdAt:le']]}/>
          </SearchItem>
        </SearchForm>

        <Table
          tableApi={table}
          columns={[
            {
              title: '用户',
              dataIndex: 'id',
              render: (id, row) => <UserMedia user={row}/>,
            },
            {
              title: '姓名',
              dataIndex: 'name',
            },
            {
              title: '性别',
              dataIndex: 'sex',
              render: sex => sexes[sex]?.name,
            },
            {
              title: '手机',
              dataIndex: 'mobile',
              render: (mobile, row) => (
                <>
                  {mobile}
                  {row.isMobileVerified ? <Box ml1 inlineBlock><CheckCircleTwoTone twoToneColor="#52c41a"/></Box> : ''}
                </>
              ),
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

export default Index;
