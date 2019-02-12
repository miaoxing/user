<?php

$canShow = $curUser->can('admin/user/show');
$enableMessage = wei()->setting('user.enableMessage');

$tags = [];
$userTags = wei()->userTagModel()->desc('sort')->indexBy('id')->findAll();
foreach ($userTags as $userTag) {
  $tags[] = ['id' => $userTag->id, 'text' => $userTag->name];
}
?>

<?= $block->css() ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/admin/rich-info.css') ?>">
<style>
  .user-popover-info {
    font-size: 1rem;
  }
</style>
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

<div class="js-user-tag-modal modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="js-user-tag-form form-horizontal" role="form">
        <div class="modal-header">
          <h5 class="modal-title">更改标签</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-3 control-label">标签</label>
            <div class="col-sm-6">
              <input type="text" class="js-user-tag-tag-ids form-control" name="tagIds" placeholder="请选择标签">
              <input type="hidden" class="js-user-tag-user-id form-control" name="userId">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $block->end() ?>

<?php require $view->getFile('@user/admin/user/userPopoverTpl.php') ?>

<?= $block->js() ?>
<script>
  window.require && require([
    'comps/bootstrap-popover-async/bootstrap-popover-async',
    'comps/select2/select2.min',
    'css!comps/select2/select2',
    'css!comps/select2-bootstrap-css/select2-bootstrap',
    'form'
  ], function () {
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

            var tags = [];
            var tagIds = [];
            for (var i in ret.data.tags) {
              tags.push(ret.data.tags[i].name);
              tagIds.push(ret.data.tags[i].id);
            }
            ret.data.tagName = tags.join(' ');
            ret.data.tagIds = tagIds.join(',');

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

    var $modal = $('.js-user-tag-modal');
    $body.on('click', '.js-user-edit-tags', function () {
      $('.js-user-tag-user-id').val($(this).data('id'));
      $('.js-user-tag-tag-ids').val($(this).data('tag-ids')).select2({
        multiple: true,
        closeOnSelect: false,
        data: <?= json_encode($tags) ?>
      });
      $modal.modal('show');
    });

    $('.js-user-tag-form').ajaxForm({
      url: $.url('admin/user-tags/replace-user-tags'),
      dataType: 'json',
      type: 'post',
      success: function (ret) {
        $.msg(ret, function () {
          if (ret.code === 1) {
            $.clearPopoverAsyncCache();
            $modal.modal('hide');
            $(document).trigger('group.changed');
          }
        });
      }
    });
  });
</script>
<?= $block->end() ?>
