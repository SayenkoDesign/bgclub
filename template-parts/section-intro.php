<?php

/*
Section - Intro
		
*/

if( ! function_exists( 'section_intro' ) ) {
 
    function section_intro() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-intro' );
        $styles = array();
        $output = '';
              
        $prefix = 'intro';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading 		    = $fields['heading'];
        $editor	            = $fields['editor'];
        $button             = $fields['button'];
              
          
        $content = '';
                
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

        if( !empty( $button ) ) {
            $content .= sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button secondary' ) ) );
        }        
                 
        $content = sprintf( '<div class="small-12 large-6 large-center columns">
                            <div class="entry-content">%s</div></div>', $content );
        
        
        $output = sprintf( '<div class="row">%s</div>', $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_intro();
    