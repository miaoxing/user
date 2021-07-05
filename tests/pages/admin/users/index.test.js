import Index from '../../../../pages/admin/users/index';
import {render} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import $ from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';
import {app} from '@mxjs/app';

bootstrap();

describe('admin/users', () => {
  beforeEach(function () {
    setUrl('admin/users');
    app.page = {
      collection: 'admin/users',
      index: true,
    };
  });

  afterEach(() => {
    resetUrl();
    app.page = {};
  });

  test('index', async () => {
    const promise = createPromise();
    const promise2 = createPromise();

    $.http = jest.fn()
      // 读取地区
      .mockImplementationOnce(() => promise.resolve({
        ret: {
          code: 0,
          data: [],
        },
      }))
      // 读取列表数据
      .mockImplementationOnce(() => promise2.resolve({
        ret: {
          code: 0,
          data: [
            {
              id: 1,
              name: '姓名1',
              nickName: '昵称2',
              displayName: '显示名称3',
              sex: 1,
              mobile: '138001380000',
              country: '中国',
              province: '广东',
              city: '深圳',
            },
          ],
        },
      }));

    const {findByText} = render(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    await findByText('姓名1');
    await findByText('显示名称3');
    await findByText('男');
    await findByText('138001380000');
    await findByText('中国 广东 深圳');

    await Promise.all([promise, promise2]);
    expect($.http).toHaveBeenCalledTimes(2);
    expect($.http).toMatchSnapshot();
  });
});
