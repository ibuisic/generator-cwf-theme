(function ($) {

  // Make the bootstrap dropdown parent clickable
  $('.dropdown > a').click(function(){
    location.href = this.href;
  });

})(jQuery);

