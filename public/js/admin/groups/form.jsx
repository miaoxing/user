import React from 'react';
import ReactDOM from 'react-dom';
import {InputGroup, Table, Form, Well, Col, Checkbox, Radio, FormGroup, FormControl, ControlLabel, Button, HelpBlock} from 'react-bootstrap';

import jqueryFrom from 'jquery-form';
import jqueryPopulate from 'jquery-populate';
import validator from 'validator';
import FormAction from 'FormAction.jsx';

class GroupForm extends React.Component {
  componentDidMount() {
    Promise.all([jqueryPopulate, jqueryFrom, validator]).then(() => {
      $(ReactDOM.findDOMNode(this))
        .populate(wei.group)
        .ajaxForm({
          url: $.url('admin/groups/update'),
          dataType: 'json',
          beforeSubmit: function (arr, $form) {
            return $form.valid();
          },
          success: function (ret) {
            $.msg(ret, function () {
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
      <Form horizontal method="post">
        <FormGroup controlId="name">
          <Col componentClass={ControlLabel} sm={2}>
            <span className="text-warning">*</span>{' '}
            名称
          </Col>
          <Col sm={4}>
            <FormControl type="text" name="name" required />
          </Col>
        </FormGroup>

        <FormGroup controlId="sort">
          <Col componentClass={ControlLabel} sm={2}>
            顺序
          </Col>
          <Col sm={4}>
            <FormControl type="number" name="sort"/>
          </Col>
        </FormGroup>

        <input type="hidden" id="id" name="id"/>

        <FormAction url={$.url('admin/groups')} />
      </Form>
    )
  }
}

ReactDOM.render(
  <GroupForm />,
  document.getElementById('root')
);
