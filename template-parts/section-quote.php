<?php

/*
Section - Quote
		
*/

if( ! function_exists( 'section_quote' ) ) {
 
    function section_quote() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-quote' );
        $styles = array();
        $output = '';
              
        $prefix = 'quote';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $editor	            = $fields['editor'];
        $photo	            = $fields['photo'];
        $photo_alignment	= strtolower( $fields['photo_alignment'] );
         
          
        $quote = '';
         
        if( !empty( $photo ) ) {
            $attachment_id = $photo;
            $size = 'large';
            $photo = wp_get_attachment_image( $attachment_id, $size );
            
            // Alignment
            $left = $right = '';
            
            if( 'right' == $photo_alignment ) {
                $left = 'large-push-6';  
                $right = 'large-pull-6';   
            }
            
            $photo = sprintf( '<div class="small-12 large-6 %s columns show-for-large">%s</div>', $left, $photo );
        }
        
        
        if( !empty( $editor ) ) {
            $quote .= $editor;
         }
      
                 
        $quote = sprintf( '<div class="small-12 large-6 %s columns"><div class="entry-quote">%s</div></div>', $right, $quote );
        
        
        $output = sprintf( '<div class="row">%s%s</div>', $photo, $quote );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_quote();
    