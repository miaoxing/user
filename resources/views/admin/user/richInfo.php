<?php

$canShow = $curUser->can('admin/user/show');
$enableMessage = wei()->setting('user.enableMessage');
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/admin/rich-info.css') ?>">
<?= $block->end() ?>

<?= $block('html') ?>
<script id="user-info-tpl" type="text/html">
  <%
  if (name && nickName && name != nickName) {
    var displayName = name + '(' + nickName + ')';
  } else if (name) {
    var displayName = name;
  } else {
    var displayName = nickName;
  }
  if (<?= (int) ($canShow && $enableMessage) ?>) {
    var url = $.url('admin/message/user', {userId: id});
  } else {
    var url = 'javascript:;';
  }
  %>
  <div class="media user-media">
    <span class="media-left <?= $canShow ? 'user-popover' : '' ?> user-popover-<%= guid = $.guid++ %>"
      data-container=".user-popover-<%= guid %>" data-id="<%= id %>">
      <a href="<%= url %>" target="_blank">
        <img class="media-object" src="<%= headImg %>">
      </a>
    </span>

    <div class="media-body text-left">
      <h4 class="media-heading">
        <a href="<%= url %>" title="<%= displayName %>">
          <%= displayName %>
        </a>
      </h4>
      <span class="media-content text-muted" title="<%= tip %>">
        <%= tip %>
      </span>
    </div>
  </div>
</script>

<script class="js-user-popover-loading-tpl" type="text/html">
  <div class="user-popover-info">
    加载中...
  </div>
</script>
<?= $block->end() ?>

<?php require $view->getFile('user:admin/user/userPopoverTpl.php') ?>

<?= $block->js() ?>
<script>
  require(['comps/bootstrap-popover-async/bootstrap-popover-async'], function () {
    var $body = $('body');

    $body.popoverAsync({
      animation: false,
      selector: '.user-popover',
      trigger: 'hover',
      html: true,
      title: '详细资料',
      loadingTemplate: $('.js-user-popover-loading-tpl').html(),
      content: function ($content, callback) {
        $.ajax({
          url: $.url('admin/user/show', {id: $(this).data('id')}),
          dataType: 'json',
          success: function (ret) {
            if (ret.code !== 1) {
              return $.msg(ret);
            }
            $content.html(template.render('user-popover-tpl', ret.data));
            $content.find('.update-group').val(ret.data.groupId);
            callback($content);
          }
        });
      }
    });

    $body.on('change', '.update-group', function () {
      $.post($.url('admin/user/moveGroup', {ids: [$(this).data('id')], groupId: $(this).val()}), function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            $(document).trigger('group.changed');
          }
        });
      }, 'json');
    });

    $body.tooltip({
      container: 'body',
      selector: '.js-user-tooltip'
    });
  });
</script>
<?= $block->end() ?>
