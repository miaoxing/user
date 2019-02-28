<?php $view->layout() ?>

<ul class="list list-indented">
  <li class="list-item-link">
    <a href="<?= $url('users/edit') ?>" class="list-item">
      <h4 class="list-title">
        个人资料
      </h4>
    </a>
  </li>
  <li class="  list-item list-divider">
    <h3 class="list-title">

    </h3>
  </li>
  <li class="list-item-link">
    <a href="<?= $url('password') ?>" class="list-item">
      <h4 class="list-title">
        修改密码
      </h4>
    </a>
  </li>
  <li class="list-item-link">
    <a href="<?= $url('password/reset') ?>" class="list-item">
      <h4 class="list-title">
        忘记密码
      </h4>
    </a>
  </li>
</ul>

<div class="m-3">
  <a class="btn btn-block btn-md btn-danger" href="<?= $url('users/logout', ['next' => $url->full('')]) ?>">
    退出登录
  </a>
</div>
