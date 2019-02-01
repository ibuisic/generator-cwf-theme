(function ($, Drupal, window, document, undefined) {

  $(document).ready(function() {
    if ($('body').hasClass('body-offcanvas')) {
      $('.navbar-toggler').on('click', function () {
        $('body').toggleClass('overflow-hidden');
      })
    }
  });

})(jQuery, Drupal, this, this.document);
 