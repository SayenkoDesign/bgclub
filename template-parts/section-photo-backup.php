<?php

/*
Section - Photo
		
*/

if( ! function_exists( 'section_photo' ) ) {
 
    function section_photo() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-photo' );
        $styles = array();
        $output = '';
              
        $prefix = 'photo';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        // Photos
        $photos = get_sub_field( 'photo_gallery' );
                
        if( empty( $photos ) ) {
            return;
        }
        
        $items = [];
        $left = $right = '';
        
        /*
        Grid size created from # photos
        */
        
        $count = count( $photos );
        
        $classes[] = sprintf( 'grid-count-%s', $count );
        
        foreach( $photos as $key => $photo ) {
            $attachment_id = $photo['ID'];
            $size = 'large';
            $photo = wp_get_attachment_image_src( $attachment_id, $size );
            $photo = sprintf( ' style="background-image:url(%s);"', $photo[0] );
            $items[] = sprintf( '<div class="grid-block grid-block-%s" %s></div>', $key + 1, $photo );
        }
        
        
          
        if( $count == 1 ) {
            $left = sprintf( '<div class="small-12 columns">%s</div>', $items[0] );
        }
        else {
            // Left side
            $left = sprintf( '<div class="small-12 large-7 columns">%s</div>', $items[0] ); 
            
            //Right Side
            if( $count > 2 ) {
                
                if( $count > 4 ) {
                    
                    $right .= sprintf( '<div class="row"><div class="small-12 large-7 columns">%s</div>
                                     <div class="small-12 large-5 columns">%s</div></div>', $items[1], $items[2] );
                    $right .= sprintf( '<div class="row"><div class="small-12 large-5 columns">%s</div>
                                     <div class="small-12 large-7 columns">%s</div></div>', $items[3], $items[4] );
                }
                else if( $count > 3 ) {
                    
                    $right = sprintf( '<div class="row"><div class="small-12 large-7 columns">%s</div>
                                     <div class="small-12 large-5 columns">%s</div></div>', $items[1], $items[2] );
                    $right .= sprintf( '<div class="column row">%s</div>', $items[3] );
                }
                else {
                    $right = sprintf( '<div class="column row">%s</div>
                                     <div class="column row">%s</div>', $items[1], $items[2] );
                }
                
                $right = sprintf( '<div class="small-12 large-5 columns">%s</div>', $right );
            }
            else {
                $right = sprintf( '<div class="small-12 large-5 columns">%s</div>', $items[1] );    
            }
        }
        
        $output = sprintf( '<div class="row expanded small-collapse">%s%s</div>', $left, $right );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_photo();
    