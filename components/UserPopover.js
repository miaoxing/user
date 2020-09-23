import React from "react";
import {Popover, Descriptions} from 'antd';
import {Image} from 'rebass';
import {Media} from "@mxjs/bootstrap";
import {ManOutlined, WomanOutlined} from '@ant-design/icons';

export default class extends React.Component {
  renderSex() {
    switch (this.props.user.sex) {
      case 1:
        return <ManOutlined style={{color: "#0c86de"}}/>

      case 2:
        return <WomanOutlined style={{color: "#f28c48"}}/>

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
                  <Descriptions.Item label="手机">{user.mobile || '-'}</Descriptions.Item>
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
