(function ($, Drupal, window, document, undefined) {

  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.<%= themeName %> = {
    attach: function(context, settings) {

      // Place your code here.
      $(document).ready(function() {
        if ($('body').hasClass('body-offcanvas')) {
          $('.navbar-toggler').on('click', function () {
            $('body').toggleClass('overflow-hidden');
          })
        }
      });

    }
  };

})(jQuery, Drupal, this, this.document);