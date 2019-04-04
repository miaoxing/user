import React from 'react';
import CListBtn from "components/CListBtn";
import Form from "components/Form";
import FormItem from "components/FormItem";
import PageHeader from "components/PageHeader";
import FormAction from "components/FormAction";

export default class extends React.Component {
  render() {
    return (
      <>
        <PageHeader>
          <CListBtn/>
        </PageHeader>

        <Form>
          <FormItem label="名称" name="name" required/>

          <FormItem label="顺序" name="sort" type="number"/>

          <FormAction/>
        </Form>
      </>
    );
  }
}
