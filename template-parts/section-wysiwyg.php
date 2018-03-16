<?php

/*
Section - WYSIWYG
		
*/

if( ! function_exists( 'section_wysiwyg' ) ) {
 
    function section_wysiwyg() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-wysiwyg' );
        $styles = array();
        $output = '';
              
        $prefix = 'wysiwyg';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading 		        = $fields['heading'];
        $editor	                = $fields['editor'];
        $button                 = $fields['button'];
                  
        $content = '';
                 
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

        if( !empty( $button ) ) {
            $content .= sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button green' ) ) );
        }        
        
        $output = sprintf( '<div class="column row"><div class="entry-content">%s</div></div>', $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_wysiwyg();
    