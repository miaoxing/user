/* global Bloodhound */
define([
  'template',
  'css!comps/typeahead.js-bootstrap3.less/typeahead',
  'comps/typeahead.js/dist/typeahead.bundle.min'
], function (template) {
  template.helper('$', $);

  var UsersPicker = function () {
    // do nothing.
  };

  $.extend(UsersPicker.prototype, {
    $el: $('body'),
    users: [],
    url: 'admin/user.json',
    placeholder: '请输入用户昵称搜索',
    searchKey: 'search',
    rows: 10,
    maxItems: 10,
    $: function (selector) {
      return this.$el.find(selector);
    },

    init: function(options) {
      $.extend(this, options);
      var that = this;
      var $typeAhead = that.$el.find('.user-typeahead');
      $typeAhead.attr('placeholder', that.placeholder);

      that.$el.append('<div class="clearfix"></div><ul class="list-group user-list-group list-unstyled"></ul>');

      // 屏蔽用户信息鼠标点击事件
      that.$el.on('click', '.user-media', function () {
        return false;
      });

      // 显示用户
      $.each(that.users, function(key, value) {
        that.addUser(value);
      });

      // 初始化搜索建议引擎
      var bestUsers = new Bloodhound({
        datumTokenizer: function (d) {
          return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
          url: $.url($.appendUrl(that.url, that.searchKey + '=%QUERY'), {rows: that.rows}),
          ajax: {
            global: false,
            success: function () {
              // do nothing.
            }
          },
          filter: function (result) {
            return result.data;
          }
        }
      });
      bestUsers.initialize();

      // 搜索框增加搜索建议
      $typeAhead.typeahead(null, {
        name: 'best-users',
        source: bestUsers.ttAdapter(),
        displayKey: 'name',
        templates: {
          empty: '<div class="empty-user-message">没有找到相关用户</div>',
          suggestion: template.compile($('#user-info-tpl').html())
        }
      }).on('typeahead:selected', function (event, suggestion) {
        that.addUser(suggestion);
      });

      // 删除商品
      this.$el.find('.user-list-group:first').on('click', '.remove-user', function () {
        $(this).parents('li:first').fadeOut(function () {
          $(this).remove();
        });
      });
    },

    addUser: function (user) {
      if (this.$el.find('.user-list-group:first').children('.list-group-item').length >= this.maxItems) {
        $.msg({
          code:-1,
          message:'超过限定个数'
        });
        return;
      }

      var listItem = template.render('user-list-item-tpl', {
        user: user,
        template: template
      });

      $(listItem).prependTo('.user-list-group').fadeIn();
    },
    clear: function () {
      this.$el.find('.user-list-group').html('');
    }
  });

  return new UsersPicker();
});
