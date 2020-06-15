<?= $block('html') ?>
<script id="user-popover-tpl" type="text/html">
  <div>
    <strong><%= nickName || '(用户' + id + ')' %></strong>
    <% if (gender == 1) { %>
    <i class="fa fa-male text-primary"></i>
    <% } else if (gender === '2') { %>
    <i class="fa fa-female text-warning"></i>
    <% } %>
  </div>
  <div class="text-truncate" title="<%= name %>">
    <span class="text-muted">姓名：</span><%= name || '-'  %>
  </div>
  <div>
    <span class="text-muted">手机：</span><%= mobile || '-' %>
    <% if (isMobileVerified) { %>
    <i class="js-user-tooltip fa fa-check-circle text-success" title="已认证"></i>
    <% } %>
  </div>
  <div>
    <span class="text-muted">地区：</span><%= country + province + city + address || '-' %>
    <% if (isRegionLocked) { %>
    <i class="js-user-tooltip fa fa-lock text-success" title="已锁定,不会被同步为外部的地区,如微信的资料"></i>
    <% } %>
  </div>
  <?php if (wei()->plugin->isInstalled('user-tag')) { ?>
    <div>
      <span class="text-muted">标签：</span><%= tagName ? (tagName + ' ') : '' %><a class="js-user-edit-tags" data-id="<%= id %>"
        data-tag-ids="<%= tagIds %>" href="javascript:;">编辑</a>
    </div>
  <?php } else { ?>
    <div>
      <span class="text-muted">分组：</span><select class="update-group form-control d-inline-block w-auto" data-id="<%= id %>">
        <option value="0"><?= wei()->group->defaultName ?></option>
        <?php foreach ($wei->group()->findAll() as $group) { ?>
          <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
        <?php } ?>
      </select>
    </div>
  <?php } ?>
  <div>
    <span class="text-muted">微信OpenID：</span> <%= wechatOpenId || '-' %>
  </div>
  <?php $event->trigger('adminUserPopover') ?>
  <div>
    <span class="text-muted">操作：</span><a href="<%= $.url('admin/user/userinfo', {id: id}) %>" target="_blank">编辑</a>
  </div>
</script>
<?= $block->end() ?>
