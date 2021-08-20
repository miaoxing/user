import UserMedia from './UserMedia';
import {render, fireEvent} from '@testing-library/react';

describe('UserMedia', () => {
  test('basic', () => {
    const result = render(<UserMedia user={{}}/>);
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
    expect(container).toMatchSnapshot();

    fireEvent.mouseOver(container.querySelector('img'));
    await result.findByText('姓名');
    expect(container).toMatchSnapshot();
    expect(result.baseElement.querySelector('.ant-popover')).toMatchSnapshot();
  });
});
