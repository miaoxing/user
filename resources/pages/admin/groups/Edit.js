import React from 'react';
import {CListBtn} from "@miaoxing/clink";
import {Form, FormItem, FormAction} from "@miaoxing/form";
import {Page, PageActions} from "@miaoxing/page";

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
