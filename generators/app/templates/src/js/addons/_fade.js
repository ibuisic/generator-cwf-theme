(function ($, window) {

  $(window).on('load', function () {
    // your code
    if ($('body').hasClass('fade')) {
      $('body').addClass('show');
    }
  });

})(jQuery, this);