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
        $grid = ''; 
        
        /*
        Grid size created from # photos
        */
        
        $count = count( $photos );
                
        foreach( $photos as $key => $photo ) {
            $attachment_id = $photo['ID'];
            $size = 'large';
            $photo = wp_get_attachment_image_src( $attachment_id, $size );
            $photo = sprintf( ' style="background-image:url(%s);"', $photo[0] );
            $items[] = sprintf( '<div class="grid-block"><div class="bg"%s></div></div>', $photo );
        }
        
        if( $count > 1 ) {
            $grid .= sprintf( '<div class="grid-left">%s</div>', array_shift( $items ) );
            $grid .= sprintf( '<div class="grid-right">%s</div>', join( '', $items ) );
        }
        else {
            $grid = join( '', $items );
        }
        
        $output = sprintf( '<div class="photo-grid grid-count-%s clearfix">%s</div>', $count, $grid );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_photo();
    