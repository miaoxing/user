import Index from '../../../../pages/admin/users/index';
import {render} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import React from 'react';
import $ from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';
import {app} from '@mxjs/app';

bootstrap();

describe('admin/users', () => {
  beforeEach(function () {
    setUrl('admin/users');
    app.page = {
      collection: 'admin/users',
      index: true
    }
  });

  afterEach(() => {
    resetUrl();
    app.page = {};
  });

  test('index', async () => {
    const promise = createPromise();

    $.http = jest.fn()
      // 读取列表数据
      .mockImplementationOnce(() => promise.resolve({
        code: 1,
        data: [
          {
            id: 1,
            name: '姓名',
            nickName: '昵称',
            sex: 1,
            mobile: '138001380000',
            country: '中国',
            province: '广东',
            city: '深圳'
          }
        ],
      }));

    const {findByText} = render(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    await findByText('姓名');
    await findByText('昵称');
    await findByText('男');
    await findByText('138001380000');
    await findByText('中国 广东 深圳');

    await Promise.all([promise]);
    expect($.http).toHaveBeenCalledTimes(1);
    expect($.http).toMatchSnapshot();
  });
});
