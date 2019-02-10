<?php $view->layout() ?>

<ul class="list list-indented">
  <li class="list-item-link">
    <a href="<?= $url('users/edit') ?>" class="list-item">
      <h4 class="list-heading">
        个人资料
      </h4>
    </a>
  </li>
  <li class="list-divider list-item">
    <h3 class="list-heading">

    </h3>
  </li>
  <li class="list-item-link">
    <a href="<?= $url('password') ?>" class="list-item">
      <h4 class="list-heading">
        修改密码
      </h4>
    </a>
  </li>
  <li class="list-item-link">
    <a href="<?= $url('password/reset') ?>" class="list-item">
      <h4 class="list-heading">
        忘记密码
      </h4>
    </a>
  </li>
</ul>

<div class="m-a">
  <a class="btn btn-block btn-md btn-danger" href="<?= $url('users/logout', ['next' => $url->full('')]) ?>">
    退出登录
  </a>
</div>
