<?php

/*
Section - Content
		
*/

if( ! function_exists( 'section_content' ) ) {
 
    function section_content() {
        
        global $post;
              
        $prefix = 'content';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading 		    = $fields['heading'];
        $editor	            = $fields['editor'];
        $photo	            = $fields['photo'];
        $photo_alignment	= strtolower( $fields['photo_alignment'] );
        $button             = $fields['button'];
        
        // Classes & Styles need to be an array
        $classes = array( 'content-block' );
        $styles = array();
          
        $content = '';
         
        if( !empty( $photo ) ) {
            $attachment_id = $photo;
            $size = 'large';
            $photo = wp_get_attachment_image_src( $attachment_id, $size );
            $photo = sprintf( ' style="background-image:url(%s);"', $photo[0] );
            
            // Alignment
            $left = $right = '';
            
            if( 'right' == $photo_alignment ) {
                $left = 'large-push-6';  
                $right = 'large-pull-6';   
            }
            
            $photo = sprintf( '<div class="photo photo-%s"%s></div><div class="small-12 large-6 %s columns show-for-large"></div>', $photo_alignment, $photo, $left );
        }
        
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

        if( !empty( $button ) ) {
            $content .= sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button secondary' ) ) );
        }        
                 
        $content = sprintf( '<div class="small-12 large-6 %s columns"><div class="entry-content">%s</div></div>', $right, $content );
        
        
        $output = sprintf( '<div class="row large-collapse">%s%s</div>', $photo, $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_content();
    