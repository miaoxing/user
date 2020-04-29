import "core-js/stable";
import "regenerator-runtime/runtime";

import React from 'react';
import {mount} from 'enzyme';
import {MemoryRouter} from 'react-router';
import $ from 'miaoxing';
import Index from '../../../../resources/pages/admin/groups/Index';
import {act} from 'react-dom/test-utils';
import app from '@miaoxing/app';

// https://github.com/enzymejs/enzyme/issues/2073#issuecomment-565736674
const waitForComponentToPaint = async (wrapper) => {
  await act(async () => {
    await new Promise(resolve => setTimeout(resolve, 0));
    wrapper.update();
  });
};

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
        data: []
      }));

    const wrapper = mount(<MemoryRouter>
      <Index/>
    </MemoryRouter>);

    waitForComponentToPaint(wrapper);
    await Promise.all([promise, promise2, promise3]);

    expect(wrapper.find('a.btn-success').text()).toBe('添加');

    expect($.get).toHaveBeenCalledTimes(3);
    expect($.get).toMatchSnapshot();
  });
});
