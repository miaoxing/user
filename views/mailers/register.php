<?php $this->layout('@mail/mail/layout.php') ?>

<p>尊敬的用户，您好!</p>

<p>您的邮箱<?= $user['email'] ?>申请了注册</p>

<p>&nbsp;</p>

<p>请点击以下链接激活帐号：</p>

<p style="word-wrap:break-word;word-break:break-all;">
  <a href="<?= $verifyUrl ?>" target="_blank"><?= $verifyUrl ?></a>
</p>

<p>&nbsp;</p>

<p>如果以上链接无法点击，请将上面的地址复制到您浏览器的地址栏进入。</p>
