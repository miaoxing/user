<?= $block('html') ?>
<script id="user-popover-tpl" type="text/html">
  <div>
    <strong><%= nickName || '(用户' + id + ')' %></strong>
    <% if (gender == 1) { %>
    <i class="fa fa-male text-primary"></i>
    <% } else { %>
    <i class="fa fa-female text-warning"></i>
    <% } %>
  </div>
  <div class="truncate" title="<%= name %>">
    姓名：<%= name || '-'  %>
  </div>
  <div>
    手机：<%= mobile || '-' %>
    <% if (isMobileVerified) { %>
    <i class="js-user-tooltip fa fa-check-circle text-success" title="已认证"></i>
    <% } %>
  </div>
  <div>
    地区：<%= country + province + city + address || '-' %>
    <% if (isRegionLocked) { %>
    <i class="js-user-tooltip fa fa-lock text-success" title="已锁定,不会被同步为外部的地区,如微信的资料"></i>
    <% } %>
  </div>
  <div>
    分组：<select class="update-group" data-id="<%= id %>">
      <option value="0"><?= $setting('user.titleDefaultGroup') ?: '未分组' ?></option>
      <?php foreach ($wei->group()->findAll() as $group) : ?>
        <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
      <?php endforeach ?>
    </select>
  </div>
  <div>
    标签：
  </div>
  <?php $event->trigger('adminUserPopover') ?>
  <div>
    操作：<a href="<%= $.url('admin/user/userinfo', {id: id}) %>" target="_blank">编辑</a>
  </div>
</script>
<?= $block->end() ?>
