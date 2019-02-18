
(function ($, Drupal, window, document, undefined) {

  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.<%= themeName %> = {
    attach: function(context, settings) {

      // Place your code here.

      // Trigger enhance
      $(document).trigger("enhance");

    }
  };

  })(jQuery, Drupal, this, this.document);
