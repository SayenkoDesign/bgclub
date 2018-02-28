<?php

/*
Section - Form
		
*/

if( ! function_exists( 'section_club_contact' ) ) {
 
    function section_club_contact() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-club-contact' );
        $styles = array();
        $output = '';
              
        $prefix = 'club_contact';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading    = $fields['heading'];
        $editor	    = $fields['editor']; 
        $content = ''; 
        
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
        }
      
        
        $form_id = 2;      
                      
        $content .= do_shortcode( sprintf( '[gravityform id="%s" title="false" description="false" ajax="true" tabindex="99"]', $form_id ) );
        
        $output = sprintf( '<div class="column row">%s</div>', $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_club_contact();