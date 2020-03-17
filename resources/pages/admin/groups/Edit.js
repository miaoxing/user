import React from 'react';
import {CListBtn} from "@miaoxing/clink";
import {Form, FormItem, FormAction} from "@miaoxing/form";
import {Page, PageActions} from "@miaoxing/page";
import curUrl from "@miaoxing/cur-url";

export default class extends React.Component {
  render() {
    return (
      <Page>
        <PageActions>
          <CListBtn/>
        </PageActions>

        <Form
          url={curUrl.apiForm()}
          valuesUrl={curUrl.api()}
          redirectUrl={curUrl.index()}
        >
          <FormItem label="名称" name="name" required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <FormAction/>
        </Form>
      </Page>
    );
  }
}
