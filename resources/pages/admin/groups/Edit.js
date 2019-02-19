import React from 'react';
import CListBtn from "components/CListBtn";
import app from 'app';
import Form from "components/Form";
import FormItem from "components/FormItem";
import PageHeader from "components/PageHeader";
import FormAction from "components/FormAction";
import axios from 'axios';

export default class GroupForm extends React.Component {
  state = {
    data: {
      sort: 50,
    },
  };

  componentDidMount() {
    if (app.id) {
      axios(app.curShowUrl(), {loading: true}).then(({data}) => this.setState(data));
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
