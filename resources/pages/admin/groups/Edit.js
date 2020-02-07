import React from 'react';
import CListBtn from "components/CListBtn";
import Form from "components/Form";
import FormItem from "components/FormItem";
import FormAction from "components/FormAction";
import {Page, PageActions} from "@miaoxing/page";
import app from 'app';

export default class extends React.Component {
  render() {
    return (
      <Page>
        <PageActions>
          <CListBtn/>
        </PageActions>

        <Form
          url={app.curApiFormUrl()}
          valuesUrl={app.curApiUrl()}
          redirectUrl={app.curIndexUrl()}
        >
          <FormItem label="名称" name="name" required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <FormAction/>
        </Form>
      </Page>
    );
  }
}
