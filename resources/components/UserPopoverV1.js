import React from 'react';
import rp from "require-promise";
import Loadable from 'react-loadable';
import Loading from "components/Loading";

const loader = rp(plugins/app/libs/artTemplate/template.min);

const UserPopoverV1 = ({data}) => {
  const UserPopover = () => <div dangerouslySetInnerHTML={{__html: template.render('user-info-tpl', data)}}/>;

  const LoadableComponent = Loadable({
    loader: () => loader.then(() => UserPopover),
    loading: Loading,
  });
  return <LoadableComponent/>
};

export default UserPopoverV1;
