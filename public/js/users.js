/* eslint-disable */
define([], function () {
  var User = function () {
    // do nothing.
  };

  var DELAY = 2000;

  $.extend(User.prototype, {
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
