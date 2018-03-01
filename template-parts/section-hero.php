<?php

/*
Hero
		
*/

if( ! function_exists( 'section_hero' ) ) {
 
    function section_hero() {
        
        global $post;
        
        
        
        $prefix = 'hero';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
              
        $heading 		= $fields['heading'];
        $description	= $fields['description'];
        
        $background_image       = $fields['background_image'];
        $background_position_x  = $fields['background_position_x'];
        $background_position_y  = $fields['background_position_y'];
        $hero_overlay           = $fields['overlay'];
        $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
        
        $buttons                = $fields['buttons'];
        
        $style = '';
        $content = '';
         
        if( !empty( $background_image ) ) {
            $attachment_id = $background_image;
            $size = 'hero';
            $background = wp_get_attachment_image_src( $attachment_id, $size );
            $style = sprintf( 'background-image: url(%s);', $background[0] );
            
            if( !empty( $style ) ) {
                $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
            }
        }
        
        
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h1' );
        }
        
        
        if( !empty( $description ) ) {
            $description = _s_wrap_text( $description, "\n" );
            $description = _s_get_heading( nl2br( $description ), 'h3' );
            $content .= $description;
         }
        
        $button_group = '';
        
        if( !empty( $buttons ) ) {

            $button_classes = array( 'button green', 'button blue-alt' );
            foreach( $buttons as $key => $button ) {
                 $button_group .= pb_get_cta_button( $button['button'], array( 'class' => $button_classes[$key] ) ); 
            }
            
            $content .= sprintf( '<p class="button-group">%s</p>', $button_group );
        }
    
        $attr = array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style );
        
        $attr['class'] .= $hero_overlay;
        	
        
        _s_section_open( $attr );	
           
        printf( '<div class="column row"><div class="entry-content">%s</div></div>', $content );
        
         _s_section_close();
         
         printf( '<div class="wave-bottom">%s</div>', get_svg( 'wave-bottom' ) );
            
    }
    
}

section_hero();
    