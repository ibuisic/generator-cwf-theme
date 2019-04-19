(function ($, document) {
  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  // Place your code here.
  $(document).ready(() => {
    if ($('body').hasClass('body-offcanvas-navbar')) {
      $('.navbar-toggler').on('click', () => {
        $('body').toggleClass('overflow-hidden');
        $('.dialog-off-canvas-main-canvas').toggleClass('overflow-hidden');
      });
    }
  });
}(jQuery, Drupal, this, this.document));
