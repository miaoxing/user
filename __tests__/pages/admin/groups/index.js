import "core-js/stable";
import "regenerator-runtime/runtime";

import React from 'react';
import {MemoryRouter} from 'react-router';
import $ from 'miaoxing';
import Index from '../../../../resources/pages/admin/groups/Index';
import app from '@miaoxing/app';
import {render, waitForElementToBeRemoved} from '@testing-library/react';

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
  });

  afterAll(() => {
    app.namespace = '';
    app.controller = '';
  });

  test('index', async () => {
    const promise = createPromise();
    const promise2 = createPromise();
    const promise3 = createPromise();

    $.get = jest.fn()
      .mockImplementationOnce(() => promise.resolve({
        code: 1,
        data: [],
      }))
      .mockImplementationOnce(() => promise2.resolve({
        code: 1
      }))
      .mockImplementationOnce(() => promise3.resolve({
        code: 1,
        data: [
          {
            id: 1,
            name: '测试'
          }
        ]
      }));

    const {container} = render(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    await Promise.all([promise, promise2, promise3]);

    expect(container.querySelector('.btn-success').innerHTML).toBe('添加');

    expect($.get).toHaveBeenCalledTimes(3);
    expect($.get).toMatchSnapshot();

    await waitForElementToBeRemoved(container.querySelector('.ant-empty'));
  });
});
