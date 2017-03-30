define(['plugins/app/js/validator'], function () {
  var User = function () {
    // do nothing.
  };

  var DELAY = 2000;
  var ENTER_KEY = 13;

  $.extend(User.prototype, {
    loginAction: function () {
      var $form = $('.js-login-form');
      $form
        .ajaxForm({
          dataType: 'json',
          beforeSubmit: function (arr, $form) {
            return $form.valid();
          },
          success: function (ret) {
            if (ret.code === 1) {
              window.location = ($.req('next') === '' ? $.url('admin') : $.req('next'));
            } else {
              $('.error-message').html(ret.message);
            }
          }
        })
        .validate();

      $form.find('input').keyup(function (e) {
        if (e.which === ENTER_KEY) {
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
