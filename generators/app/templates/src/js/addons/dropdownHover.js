(function ($) {
  // Make the bootstrap dropdown parent clickable
  $('.dropdown > a').click(function () {
    window.location.href = this.href;
  });
}(jQuery));
