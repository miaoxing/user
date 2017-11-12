import React from 'react';
import ReactDOM from 'react-dom';
import {InputGroup, Table, Form, Well, Col, Checkbox, Radio, FormGroup, FormControl, ControlLabel, Button, HelpBlock} from 'react-bootstrap';

import jqueryFrom from 'jquery-form';
import jqueryPopulate from 'jquery-populate';
import validator from 'validator';
import {FormRow, FormAction} from 'components';

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
        <FormRow label="名称" name="name" required />

        <FormRow label="顺序" name="sort" type="number" />

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
