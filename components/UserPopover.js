import React from 'react';
import {Popover, Descriptions} from 'antd';
import {Image, Box} from '@mxjs/box';
import {Media} from '@mxjs/bootstrap';
import {ManOutlined, WomanOutlined, CheckCircleTwoTone} from '@ant-design/icons';
import PropTypes from 'prop-types';

export default class extends React.Component {
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
              <Image src={user.avatar} width={96} height={96} mr={3}/>
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
                    {user.isMobileVerified ? <Box ml={1}><CheckCircleTwoTone twoToneColor="#52c41a"/></Box> : ''}
                  </Descriptions.Item>
                  <Descriptions.Item label="地区">
                    {[user.country, user.province, user.city].filter(el => el).join(' ') || '-'}
                  </Descriptions.Item>
                </Descriptions>
              </Media.Body>
            </Media>
          </>}>
          <Image src={user.avatar} width={48} height={48} mr={3}/>
        </Popover>
        <Media.Body>
          {user.displayName}
        </Media.Body>
      </Media>
    );
  }
}
