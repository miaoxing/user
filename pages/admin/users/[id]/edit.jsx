import {CListBtn} from '@mxjs/a-clink';
import {Page, PageActions} from '@mxjs/a-page';
import {Form, FormItem, FormAction} from '@mxjs/a-form';
import {Checkbox} from 'antd';

const Edit = () => {
  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form>
        <FormItem label="姓名" name="name"/>
        <FormItem label="手机" name="mobile" extra={
          <FormItem name="isMobileVerified" valuePropName="checked">
            <Checkbox>已验证</Checkbox>
          </FormItem>
        }/>
        <FormItem name="id" type="hidden"/>
        <FormAction/>
      </Form>
    </Page>
  );
};

export default Edit;
