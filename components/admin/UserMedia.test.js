import UserMedia from './UserMedia';
import {render, fireEvent} from '@testing-library/react';
import {ConfigProvider} from 'antd';

describe('UserMedia', () => {
  test('basic', () => {
    const result = render(
      <ConfigProvider theme={{hashed: false}}>
        <UserMedia user={{}}/>
      </ConfigProvider>
    );
    expect(result.container).toMatchSnapshot();
  });

  test('user', async () => {
    const {container, ...result} = render(<UserMedia user={{
      sex: 1,
      name: 'name',
      nickName: 'nickName',
      displayName: 'displayName',
      avatar: 'avatar',
      mobile: 'mobile',
      isMobileVerified: true,
      country: 'country',
      province: 'province',
      city: 'city',
    }}/>);
    await result.findByText('displayName');

    fireEvent.mouseOver(container.querySelector('img'));
    await result.findByText('姓名');
  });
});
