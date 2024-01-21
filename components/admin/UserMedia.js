import {Popover, Descriptions} from 'antd';
import {Box} from '@mxjs/a-box';
import Media from '@mxjs/a-media';
import {ManOutlined, WomanOutlined, CheckCircleTwoTone} from '@ant-design/icons';
import PropTypes from 'prop-types';
import {Avatar} from '@miaoxing/admin';

const UserMedia = ({user, body}) => {
  return (
    <Media>
      <Popover
        placement="rightTop"
        trigger="hover"
        content={<>
          <Media>
            <Avatar user={user} shape="square" size={96}/>
            <Media.Body w={320}>
              <Descriptions title={
                <>
                  {user.nickName}
                  {' '}
                  {user.sex === 1 && <ManOutlined style={{color: '#0c86de'}}/>}
                  {user.sex === 2 && <WomanOutlined style={{color: '#f28c48'}}/>}
                </>
              } column={1}>
                <Descriptions.Item label="姓名">{user.name}</Descriptions.Item>
                <Descriptions.Item label="手机">
                  {user.mobile || '-'}
                  {' '}
                  {user.isMobileVerified ? <Box as={CheckCircleTwoTone} ml={1} alignSelf="center" twoToneColor="#52c41a"/> : ''}
                </Descriptions.Item>
                <Descriptions.Item label="地区">
                  {[user.country, user.province, user.city].filter(el => el).join(' ') || '-'}
                </Descriptions.Item>
              </Descriptions>
            </Media.Body>
          </Media>
        </>}>
        <Avatar user={user} shape="square" size={54}/>
      </Popover>
      <Media.Body>
        {user.displayName}
        {body && <Box color="gray.500">{body}</Box>}
      </Media.Body>
    </Media>
  );
};

UserMedia.propTypes = {
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
  body: PropTypes.node,
};

export default UserMedia;
