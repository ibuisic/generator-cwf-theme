(function ($, Drupal, window, document) {
  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.<%= themeName %> = {
    attach(context, settings) {
      // Place your code here.

      // Trigger enhance
      $(document).trigger('enhance');
    },
  };
}(jQuery, Drupal, this, this.document));
