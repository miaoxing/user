import { Component } from 'react';
import {Popover, Descriptions} from 'antd';
import {Box} from '@mxjs/box';
import Media from '@mxjs/a-media';
import {ManOutlined, WomanOutlined, CheckCircleTwoTone} from '@ant-design/icons';
import PropTypes from 'prop-types';
import {Avatar} from '@miaoxing/admin';

export default class extends Component {
  static propTypes = {
    user: PropTypes.shape({
      sex: PropTypes.number,
      name: PropTypes.string,
      nickName: PropTypes.string,
      displayName: PropTypes.string,
      avatar: PropTypes.string,
      mobile: PropTypes.string,
      isMobileVerified: PropTypes.bool,
      country: PropTypes.string,
      province: PropTypes.string,
      city: PropTypes.string,
    }).isRequired,
  };

  renderSex() {
    switch (this.props.user.sex) {
      case 1:
        return <ManOutlined style={{color: '#0c86de'}}/>;

      case 2:
        return <WomanOutlined style={{color: '#f28c48'}}/>;

      default:
        return '';
    }
  }

  render() {
    const user = this.props.user;
    return (
      <Media>
        <Popover
          placement="rightTop"
          trigger="hover"
          content={<>
            <Media>
              <Avatar user={user} shape="square" size={96}/>
              <Media.Body css={{width: 320}}>
                <Descriptions title={
                  <>
                    {user.nickName}
                    {' '}
                    {this.renderSex()}
                  </>
                } column={1}>
                  <Descriptions.Item label="姓名">{user.name}</Descriptions.Item>
                  <Descriptions.Item label="手机">
                    {user.mobile || '-'}
                    {' '}
                    {user.isMobileVerified ? <Box ml1><CheckCircleTwoTone twoToneColor="#52c41a"/></Box> : ''}
                  </Descriptions.Item>
                  <Descriptions.Item label="地区">
                    {[user.country, user.province, user.city].filter(el => el).join(' ') || '-'}
                  </Descriptions.Item>
                </Descriptions>
              </Media.Body>
            </Media>
          </>}>
          <Avatar user={user} shape="square" size={48}/>
        </Popover>
        <Media.Body>
          {user.displayName}
        </Media.Body>
      </Media>
    );
  }
}
