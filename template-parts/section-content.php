<?php

/*
Section - Content
		
*/

if( ! function_exists( 'section_content' ) ) {
 
    function section_content() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-content-block' );
        $styles = array();
        $output = '';
              
        $prefix = 'content';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading 		        = $fields['heading'];
        $editor	                = $fields['editor'];
        $photo	                = $fields['photo'];
        $photo_alignment	    = strtolower( $fields['photo_alignment'] );
        $background_position_x  = $fields['background_position_x'];
        $background_position_y  = $fields['background_position_y'];
        $button                 = $fields['button'];
                  
        $content = '';
        
        $spacer = '';
         
        if( !empty( $photo ) ) {
            $style = '';
            $attachment_id = $photo;
            $size = 'large';
            $photo = wp_get_attachment_image_src( $attachment_id, $size );
            $style = sprintf( 'background-image:url(%s);', $photo[0] );
            $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
            $style = sprintf( ' style="%s"', $style );
            // Alignment
            $left = $right = '';
            
            
            if( 'left' == $photo_alignment ) {
                $spacer = '<div class="small-12 large-6 columns show-for-large">&nbsp;</div>';  
            }
            
            $photo = sprintf( '<div class="photo photo-%s"%s></div>', $photo_alignment, $style );
        }
        
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

        if( !empty( $button ) ) {
            $content .= sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button green' ) ) );
        }        
                 
        $content = sprintf( '%s<div class="small-12 large-6 columns"><div class="entry-content">%s</div></div>', $spacer, $content );
        
        
        $output = sprintf( '<div class="row large-collapse">%s%s</div>', $photo, $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_content();
    