<?= $block('css') ?>
<link rel="stylesheet" href="<?= $asset('plugins/user/css/admin/users-picker.css') ?>">
<?= $block->end() ?>

<?= $block('html') ?>
<script id="user-list-item-tpl" type="text/html">
  <li class="list-group-item">
    <%== template.render("user-info-tpl", user) %>
    <div class="media-actions">
      <a href="javascript:;" title="删除" class="light-grey remove-user">
        <i class="fa fa-times-circle-o"></i>
      </a>
    </div>
    <input type="hidden" name="userIds[]" value="<%= user.id %>">
  </li>
</script>
<?= $block->end() ?>



