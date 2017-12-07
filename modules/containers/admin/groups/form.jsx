import React from 'react';
import {Button} from 'react-bootstrap';
import {Page, PageHeader, FormItem, Form, FormAction} from 'components';

const loader = Promise.all([
  import('jquery-populate'),
  import('jquery-form'),
  import('jquery-validation-mx')
]);

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
          <FormItem label="名称" name="name" required />

          <FormItem label="顺序" name="sort" type="number" />

          <input type="hidden" id="id" name="id" />

          <FormAction url={$.url('admin/groups')} />
        </Form>
      </Page>
    )
  }
}

export default GroupForm;
