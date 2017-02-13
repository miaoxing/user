define(function () {
  var User = function () {

  };

  $.extend(User.prototype, {
    loginAction: function () {
      $('.js-login-form')
        .ajaxForm({
          dataType: 'json',
          success: function (ret) {
            if (ret.code === 1) {
              window.location = ($.req('next') == '' ? $.url('admin') : $.req('next'));
            } else {
              $('.error-message').html(ret.message);
            }
          }
        })
        .find('input').keyup(function (e) {
          if (e.which == 13) {
            return;
          }
          $('.error-message').html('');
        });
    }
  });

  return new User;
});
