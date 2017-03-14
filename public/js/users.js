define(function () {
  var User = function () {
    // do nothing.
  };

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
    }
  });

  return new User();
});
