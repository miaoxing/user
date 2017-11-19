import React from 'react';
import ReactDOM from 'react-dom';
import {Button} from 'react-bootstrap';
import {Page, PageHeader, FormRow, Form, FormAction} from 'components';

import jQueryFrom from 'jquery-form';
import jQueryPopulate from 'jquery-populate';
import validator from 'validator';

const loader = Promise.all([jQueryPopulate, jQueryFrom, validator]);

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
      <Page>
        <PageHeader>
          <Button href={$.url('admin/groups')}>返回列表</Button>
        </PageHeader>
        <Form horizontal className="js-groups-form" method="post">
          <FormRow label="名称" name="name" required />

          <FormRow label="顺序" name="sort" type="number" />

          <input type="hidden" id="id" name="id" />

          <FormAction url={$.url('admin/groups')} />
        </Form>
      </Page>
    )
  }
}

ReactDOM.render(
  <GroupForm />,
  document.getElementById('root')
);
