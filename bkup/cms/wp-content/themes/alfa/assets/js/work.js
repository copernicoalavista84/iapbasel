/*global $:false */
(function($) {
	"use strict";
    
    $.extend($.easing, window.easing);
    $(document).ready(function() {
        $("html").niceScroll();
    });
    
    $(function() {
        $( '#cbp-fwslider' ).cbpFWSlider();
    } );
})(jQuery);