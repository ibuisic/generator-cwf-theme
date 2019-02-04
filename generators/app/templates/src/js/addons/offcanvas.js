(function ($, document) {

  // To understand behaviors, see https://drupal.org/node/756722#behaviors
   // Place your code here.
   $(document).ready(function() {
    if ($('body').hasClass('body-offcanvas')) {
      $('.navbar-toggler').on('click', function () {
        $('body').toggleClass('overflow-hidden');
        $('.dialog-off-canvas-main-canvas').toggleClass('overflow-hidden');
      })
    }
  });

})(jQuery, Drupal, this, this.document);