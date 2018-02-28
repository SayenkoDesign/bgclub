<?php

/*
Section - Intro
		
*/

if( ! function_exists( 'section_intro_background' ) ) {
 
    function section_intro_background() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-intro-background' );
        $styles = array();
        $output = '';
              
        $prefix = 'intro_background';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
          
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                              
        $icon 		        = $fields['icon'];
        $heading 		    = $fields['heading'];
        $editor	            = $fields['editor'];
        
        $background_image       = $fields['background_image'];
        $background_position_x  = $fields['background_position_x'];
        $background_position_y  = $fields['background_position_y'];
        $hero_overlay           = $fields['background_overlay'];
        $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
              
          
        $style = '';
        $content = '';
         
        if( !empty( $background_image ) ) {
            $attachment_id = $background_image;
            $size = 'hero';
            $background = wp_get_attachment_image_src( $attachment_id, $size );
            $styles['background-image'] = sprintf( 'url(%s)', $background[0] );
            
            if( !empty( $style ) ) {
                $styles['background-position'] = sprintf( '%s %s', $background_position_x, $background_position_y );
            }
        }
        
        if( !empty( $icon ) ) {
            $attachment_id = $icon;
            $size = 'thumbnail';
            $icon = sprintf( '<div class="thumbnail">%s</div>', wp_get_attachment_image( $attachment_id, $size ) );
        }
        
        
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

     
                 
        $content = sprintf( '<div class="entry-content">%s</div>', $content );
        
        
        $output = sprintf( '<div class="column row">%s<div class="box">%s</div></div>', $icon, $content );
        
        $photo = 
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_intro_background();
    