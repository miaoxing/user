import Form from '../../../../../pages/admin/users/[id]/edit';
import {fireEvent, render, screen} from '@testing-library/react';
import {MemoryRouter} from 'react-router';
import React from 'react';
import {app} from '@mxjs/app';
import $ from 'miaoxing';
import {bootstrap, createPromise, setUrl, resetUrl} from '@mxjs/test';

bootstrap();

describe('admin/users', () => {
  beforeEach(() => {
    setUrl('admin/users/1/edit');
    app.page = {
      collection: 'admin/users',
      index: false,
    };
  });

  afterEach(() => {
    resetUrl();
    app.page = {};
  });

  test('form', async () => {
    const promise = createPromise();
    const promise2 = createPromise();

    $.http = jest.fn()
      // 读取默认数据
      .mockImplementationOnce(() => promise.resolve({
        code: 1,
        data: {
          id: 1,
          name: '姓名2',
          mobile: '13800138000',
          isMobileVerified: true,
        },
      }))
      // 提交
      .mockImplementationOnce(() => promise2.resolve({
        code: 1,
      }));

    const {container, getByLabelText, findByDisplayValue} = render(<MemoryRouter>
      <Form/>
    </MemoryRouter>);

    await Promise.all([promise]);
    expect($.http).toHaveBeenCalledTimes(1);
    expect($.http).toMatchSnapshot();

    // 看到表单加载了数据
    await findByDisplayValue('姓名2');
    await findByDisplayValue('13800138000');
    expect(container.querySelector('#isMobileVerified').checked).toBeTruthy();

    // 提交表单
    fireEvent.change(getByLabelText('姓名'), {target: {value: '新名称'}});
    fireEvent.click(screen.getByText('提 交'));

    await Promise.all([promise2]);
    expect($.http).toHaveBeenCalledTimes(2);
    expect($.http).toMatchSnapshot();
  });
});
