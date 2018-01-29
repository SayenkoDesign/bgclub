(function (document, window, $) {

	'use strict';
    
    // Scroll up show header

	var $site_header =  $('.site-header');

	// clone header
	var $sticky = $site_header.clone()
							   .prop('id', 'masthead-fixed' )
							   .attr('aria-hidden','true')
							   .addClass('fixed')
							   .insertBefore('#masthead');
     

	var header_height = $site_header.height();
	var lastScrollTop = 0;
    var wait = 25; // distance in pixels to wait before showing

	$(window).scroll(function() {

		var scroll = $(window).scrollTop();

		if (scroll < 400 ) {
            $sticky.removeClass("show");
            return;
		} 

	   var st = $(this).scrollTop();
       
       console.log('st: ' + st);
       console.log('lastScrollTop: ' + lastScrollTop);
       
	   if (st > lastScrollTop){
		   // downscroll code
		   $sticky.removeClass("show");
	   } else {
		  // upscroll code
          
          if( lastScrollTop - st >= wait ) {
              $sticky.addClass("show");
          }
          
		  
	   }
	   lastScrollTop = st;

	});
    

}(document, window, jQuery));