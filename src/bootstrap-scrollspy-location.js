'use strict';

(function($) {

  // https://stackoverflow.com/questions/23070777/updating-address-bar-window-location-hash-with-scrollspy
  $(window).on('activate.bs.scrollspy', function (e) {
      history.replaceState({}, '', $("a[href^='#']", e.target).attr('href'));
  });

})( jQuery );

