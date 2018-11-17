import React from 'react';
import {FormAction, Page, PageHeader} from 'components';
import CListBtn from "components/bs4/CListBtn";
import app from 'app';
import Form from "components/Form";
import FormItem from "components/bs4/FormItem";

export default class GroupForm extends React.Component {
  state = {
    data: {},
  };

  componentDidMount() {
    if (app.id) {
      app.get(app.curShowUrl()).then(ret => this.setState(ret));
    }
  }

  render() {
    return (
      <Page>
        <PageHeader>
          <CListBtn/>
        </PageHeader>
        <Form initialValues={this.state.data} url={app.curFormUrl()}>
          <FormItem label="名称" name="name" data-rule-maxlength={10} required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <input type="hidden" id="id" name="id"/>

          <FormAction url={$.url('admin/groups')}/>
        </Form>
      </Page>
    );
  }
}
