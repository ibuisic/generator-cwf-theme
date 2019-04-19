(function ($) {
  $(window).scroll(function () {
    if ($(this).scrollTop() !== 0) {
      $('#btt').addClass('show');
    }
    else {
      $('#btt').removeClass('show');
    }
  });

  $('#btt').click(() => {
    $('body,html').animate({
      scrollTop: 0,
    }, 800);
  });
}(jQuery, this));
