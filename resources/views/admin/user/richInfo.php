<?php

$canShow = wei()->can->can('admin/user/show');
?>

<?= $block('css') ?>
<style type="text/css">
  .user-popover .popover {
    margin-left: 0;
  }

  .user-popover-info {
    width: 200px;
  }

  .user-popover-info > div {
    padding-bottom: 6px;
  }

  .user-popover-info > div:last-child {
    padding-bottom: 0;
  }

  .update-group {
    height: 24px;
    line-height: 24px;
  }
</style>
<?= $block->end() ?>

<?= $block('html') ?>
<script id="user-info-tpl" type="text/html">
  <div class="media user-media">
    <span class="media-left <?= $canShow ? 'user-popover' : '' ?> user-popover-<%= guid = $.guid++ %>" data-container=".user-popover-<%= guid %>" data-id="<%= id %>">
      <a href="<?= $canShow ? "<%= $.url('admin/message/user', {userId: id}) %>" : 'javascript:;' ?>" target="_blank">
        <img class="media-object" src="<%= headImg || '<?= $asset('assets/images/head/default-light.jpg') ?>' %>">
      </a>
    </span>

    <div class="media-body text-left">
      <h4 class="media-heading">
        <a href="<?= $canShow ? "<%= $.url('admin/message/user', {userId: id}) %>" : 'javascript:;' ?>">
          <% if (name && nickName && name != nickName) { %>
            <%= name %>(<%= nickName %>)
          <% } else if (name) { %>
            <%= name %>
          <% } else if (nickName) { %>
            <%= nickName %>
          <% } %>
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

<?= $block('js') ?>
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
