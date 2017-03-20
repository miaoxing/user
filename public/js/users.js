define(function () {
  var User = function () {
    // do nothing.
  };

  var DELAY = 2000;

  $.extend(User.prototype, {
    loginAction: function () {
      var enterKey = 13;  // 回车
      $('.js-login-form')
        .ajaxForm({
          dataType: 'json',
          success: function (ret) {
            if (ret.code === 1) {
              window.location = ($.req('next') === '' ? $.url('admin') : $.req('next'));
            } else {
              $('.error-message').html(ret.message);
            }
          }
        })
        .find('input').keyup(function (e) {
          if (e.which === enterKey) {
            return;
          }
          $('.error-message').html('');
        });
    },

    // 展示页面内的提示信息
    pageMsg: function (ret, fn) {
      var $retMessage = $('.js-ret-message');
      if (ret.code === 1) {
        $retMessage.addClass('text-success').removeClass('text-danger');
      } else {
        $retMessage.addClass('text-danger').removeClass('text-success');
      }
      $retMessage.html(ret.message);

      setTimeout(function () {
        if (fn) {
          fn();
        }
      }, DELAY);
    }
  });

  return new User();
});
