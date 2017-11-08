import React from 'react';
import ReactDOM from 'react-dom';
import {InputGroup, Table, Form, Well, Col, Checkbox, Radio, FormGroup, FormControl, ControlLabel, Button, HelpBlock} from 'react-bootstrap';

class GroupForm extends React.Component {
  componentDidMount() {
    Promise.all([;
      import(/* webpackChunkName:"jquery-populate" */ 'vendor/miaoxing/app/public/libs/jquery.populate/jquery.populate'),;
      import(/* webpackChunkName:"jquery-form" */ 'comps/jquery-form/jquery.form');
    ]).then(() => {
      $(ReactDOM.findDOMNode(this))
        .populate(wei.group)
        .ajaxForm({
          url: $.url('admin/group/update'),
          dataType: 'json',
          success: function (ret) {
            $.msg(ret, function () {
              if (ret.code === 1) {
                window.location = $.url('admin/group');
              }
            });
          }
        });
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
            <FormControl type="text" name="name" />
          </Col>
        </FormGroup>

        <FormGroup controlId="sort">
          <Col componentClass={ControlLabel} sm={2}>
            顺序
          </Col>
          <Col sm={4}>
            <FormControl type="number" name="sort" />
          </Col>
        </FormGroup>

        <input type="hidden" id="id" name="id" />

        <FormGroup className="clearfix form-actions">
          <Col smOffset={2}>
            <Button bsStyle="primary" type="submit">
              <i className="fa fa-check bigger-110" />
              {' '}提交
            </Button>
            &nbsp; &nbsp; &nbsp;
            <Button componentClass="a" href={$.url('admin/group')}>
              <i className="fa fa-undo bigger-110" />
              {' '}返回列表
            </Button>
          </Col>
        </FormGroup>
      </Form>
    )
  }
}

ReactDOM.render(
  <GroupForm />,
  document.getElementById('root')
);
