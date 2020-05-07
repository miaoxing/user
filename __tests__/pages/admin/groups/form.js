import "core-js/stable";
import "regenerator-runtime/runtime";

import React from 'react';
import $ from 'miaoxing';
import Form from '../../../../resources/pages/admin/groups/New';
import app from '@miaoxing/app';
import {render, screen, fireEvent} from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect'
import {createMemoryHistory} from "history";
import {Router} from "react-router";

// https://jestjs.io/docs/en/manual-mocks#mocking-methods-which-are-not-implemented-in-jsdom
Object.defineProperty(window, 'matchMedia', {
  writable: true,
  value: jest.fn().mockImplementation(query => ({
    matches: false,
    media: query,
    onchange: null,
    addListener: jest.fn(), // deprecated
    removeListener: jest.fn(), // deprecated
    addEventListener: jest.fn(),
    removeEventListener: jest.fn(),
    dispatchEvent: jest.fn(),
  })),
});

function createPromise() {
  let res, rej;

  const promise = new Promise((resolve, reject) => {
    res = (result) => {
      resolve(result);
      return promise;
    };
    rej = (result) => {
      reject(result);
      return promise;
    };
  })

  promise.resolve = res;
  promise.reject = rej;

  return promise;
}

describe('admin/groups', () => {
  beforeAll(() => {
    app.namespace = 'admin';
    app.controller = 'groups';
    app.action = 'new';
  });

  afterAll(() => {
    app.namespace = '';
    app.controller = '';
    app.action = '';
  });

  test('form', async () => {
    const promise = createPromise();
    const promise2 = createPromise();

    $.get = jest.fn()
      .mockImplementationOnce(() => promise.resolve({
        code: 1,
        data: {
          id: 1,
          sort: 50,
        },
      }))
      .mockImplementationOnce(() => promise2.resolve({
        code: 1,
        data: []
      }));

    const promise3 = createPromise();
    $.post = jest.fn()
      .mockImplementationOnce(() => promise3.resolve({
        code: 1,
      }));
    $.ret = jest.fn(function (ret) {
      return {
        suc: (fn) => {
          if (ret.code === 1) {
            fn();
          }
        }
      }
    });

    const history = createMemoryHistory({
      initialEntries: [
        '/admin/groups/new'
      ]
    });
    const {getByLabelText} = render(<Router history={history}>
      <Form/>
    </Router>);

    await Promise.all([promise, promise2]);
    expect($.get).toHaveBeenCalledTimes(2);
    expect($.get).toMatchSnapshot();

    // 看到表单加载了数据
    expect(getByLabelText('名称').value).toBe('');
    expect(getByLabelText('顺序').value).toBe('50');

    // 提交表单
    fireEvent.change(getByLabelText('名称'), {target: {value: '测试分组'}});
    fireEvent.click(screen.getByText('提 交'));

    await Promise.all([promise3]);
    expect($.post).toHaveBeenCalledTimes(1);
    expect($.post).toMatchSnapshot();

    // 操作成功后跳转到列表页
    expect($.ret).toHaveBeenCalledTimes(1);
    expect($.ret).toHaveBeenCalledWith(await promise3);
    expect(history.location.pathname).toBe('/admin/groups');
  });
});
