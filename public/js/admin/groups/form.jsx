import React from 'react';
import ReactDOM from 'react-dom';
import {Table, Form, Row, Col, FormGroup, Button} from 'react-bootstrap';

import jqueryFrom from 'jquery-form';
import jqueryPopulate from 'jquery-populate';
import validator from 'validator';
import {Content, PageHeader, FormRow, FormAction} from 'components';

const loader = Promise.all([jqueryPopulate, jqueryFrom, validator]);

class GroupForm extends React.Component {
  componentDidMount() {
    loader.then(() => {
      $('.js-groups-form')
        .populate(wei.group)
        .ajaxForm({
          url: $.url('admin/groups/update'),
          dataType: 'json',
          beforeSubmit: (arr, $form) => $form.valid(),
          success: (ret) => {
            $.msg(ret, () => {
              if (ret.code === 1) {
                window.location = $.url('admin/groups');
              }
            });
          }
        })
        .validate();
    });
  }

  render() {
    return (
      <Content>
        <PageHeader>
          <Button href={$.url('admin/groups')}>返回列表</Button>
        </PageHeader>
        <Row>
          <Col xs={12}>
            <Form horizontal className="js-groups-form" method="post">
              <FormRow label="名称" name="name" required />

              <FormRow label="顺序" name="sort" type="number" />

              <input type="hidden" id="id" name="id" />

              <FormAction url={$.url('admin/groups')} />
            </Form>
          </Col>
        </Row>
      </Content>
    )
  }
}

ReactDOM.render(
  <GroupForm />,
  document.getElementById('root')
);
