(function (document, window, $) {

	'use strict';

	// Load Foundation
	$(document).foundation();
    
    
    $(window).on('load changed.zf.mediaquery', function(event, newSize, oldSize) {
        
        $( '.nav-primary' ).doubleTapToGo();
        
        if( ! Foundation.MediaQuery.atLeast('xlarge') ) {
            $( '.nav-primary' ).doubleTapToGo( 'destroy' );          
        }        
        
    });
    
    var timer;
    
    $(".nav-primary .menu > li").on( 'mouseenter', function () {
            
            var nav = $(this).closest('nav');
            
            timer = setTimeout(function(){
                if( $('.sub-menu', nav).height() === 0 ){
                    $(nav).find('.sub-menu, .menu > li').attr('data-is','open');
                } 
            }, 250);
            
    } );
    
    $('body').on( 'mouseleave', '.nav-primary', function () {
        clearTimeout(timer);
        $(this).find('.sub-menu, .menu > li').attr('data-is','close');
    } );
   

    
    // Toggle menu
    
    $('li.menu-item-has-children > a').on('click',function(e){
        
        var $toggle = $(this).parent().find('.sub-menu-toggle');
        
        if( $toggle.is(':visible') ) {
            $toggle.trigger('click');
        }
        
        e.preventDefault();

    });
    
    
    $(document).on('click', '.play-video', playVideo);
    
    function playVideo() {
                
        var $this = $(this);
        
        var url = $this.data('src');
                
        var $modal = $('#' + $this.data('open'));
        
        /*
        $.ajax(url)
          .done(function(resp){
            $modal.find('.flex-video').html(resp).foundation('open');
        });
        */
        
        var $iframe = $('<iframe>', {
            src: url,
            id:  'video',
            frameborder: 0,
            scrolling: 'no'
            });
        
        $iframe.appendTo('.video-placeholder', $modal );        
        
        
        
    }
    
    // Make sure videos don't play in background
    $(document).on(
      'closed.zf.reveal', '#modal-video', function () {
        $(this).find('.video-placeholder').html('');
      }
    );
    
}(document, window, jQuery));
