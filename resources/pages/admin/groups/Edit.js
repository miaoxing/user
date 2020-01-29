import React from 'react';
import CListBtn from "components/CListBtn";
import Form from "components/Form";
import FormItem from "components/FormItem";
import FormAction from "components/FormAction";
import Page from "components/Page";
import PageActions from "components/PageActions";

export default class extends React.Component {
  render() {
    return (
      <Page>
        <PageActions>
          <CListBtn/>
        </PageActions>

        <Form>
          <FormItem label="名称" name="name" required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <FormAction/>
        </Form>
      </Page>
    );
  }
}
