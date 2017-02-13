define([
  'css!comps/typeahead.js-bootstrap3.less/typeahead',
  'template',
  'comps/typeahead.js/dist/typeahead.bundle.min'
], function () {
  template.helper('$', $);

  var UsersPicker = function () {
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
      var self = this;
      var $typeAhead = self.$el.find('.user-typeahead');
      $typeAhead.attr("placeholder", self.placeholder);

      self.$el.append('<div class="clearfix"></div><ul class="list-group user-list-group list-unstyled"></ul>');

      // 屏蔽用户信息鼠标点击事件
      self.$el.on('click', '.user-media', function (e) {
        return false;
      });

      // 显示用户
      for (var i in self.users) {
        self.addUser(self.users[i]);
      }

      // 初始化搜索建议引擎
      var bestUsers = new Bloodhound({
        datumTokenizer: function (d) {
          return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
          url: $.url($.appendUrl(self.url, self.searchKey + '=%QUERY'), {rows: self.rows}),
          ajax: {
            global: false,
            success: function () {
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
      }).on('typeahead:selected', function (event, suggestion, name) {
        self.addUser(suggestion);
      });

      // 删除商品
      this.$el.find('.user-list-group:first').on('click', '.remove-user', function () {
        $(this).parents('li:first').fadeOut(function () {
          $(this).remove();
        });
      });
    },

    addUser: function (user) {
      if(this.$el.find('.user-list-group:first').children('.list-group-item').length >= this.maxItems) {
        $.msg({code:-1, message:'超过限定个数'});
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
