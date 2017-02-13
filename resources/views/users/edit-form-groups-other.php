<div class="js-form-group-name form-group-name form-group">
  <label for="name" class="control-label">姓名</label>

  <div class="col-control">
    <input type="text" class="form-control" id="name" name="name" placeholder="请输入姓名">
  </div>
</div>

<div class="js-form-group-address form-group-address form-group">
  <label for="address" class="control-label">地址</label>

  <div class="col-control">
    <textarea class="form-control" id="address" name="address" placeholder="请输入地址"></textarea>
  </div>
</div>

<?php $event->trigger('userEditFormRender', [$user]) ?>
