import React from 'react';
import CListBtn from "components/bs4/CListBtn";
import app from 'app';
import Form from "components/bs4/Form";
import FormItem from "components/bs4/FormItem";
import PageHeader from "components/bs4/PageHeader";
import FormAction from "components/bs4/FormAction";

export default class GroupForm extends React.Component {
  state = {
    data: {
      sort: 50,
    },
  };

  componentDidMount() {
    if (app.id) {
      app.get(app.curShowUrl()).then(ret => this.setState(ret));
    }
  }

  render() {
    return (
      <>
        <PageHeader>
          <div className="float-right">
            <CListBtn/>
          </div>
          {wei.page.controllerTitle}
        </PageHeader>
        <Form initialValues={this.state.data} url={app.curFormUrl()}>
          <FormItem label="名称" name="name" required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <FormAction/>
        </Form>
      </>
    );
  }
}
