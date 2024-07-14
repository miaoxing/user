import { CListBtn } from '@mxjs/a-clink';
import { Page, PageActions } from '@mxjs/a-page';
import { Form, FormItem, FormAction } from '@mxjs/a-form';
import { Checkbox } from 'antd';
import { Section } from '@mxjs/a-section';

const Edit = () => {
  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form>
        <Section>
          <FormItem label="姓名" name="name"/>
          <FormItem label="手机" name="mobile" extra={
            <FormItem name="isMobileVerified" valuePropName="checked" style={{marginBottom: 0}}>
              <Checkbox>已验证</Checkbox>
            </FormItem>
          }/>
        </Section>

        <FormAction variant="card"/>
      </Form>
    </Page>
  );
};

export default Edit;
