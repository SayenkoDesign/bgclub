<?php

/*
Section - Form
		
*/

if( ! function_exists( 'section_form' ) ) {
 
    function section_form() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-form' );
        $styles = array();
        $output = '';
              
        $prefix = 'form';
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
      
        if( !empty( $fields['gravity_form'] ) ) {
            $form_id = $fields['gravity_form'];                     
            $content .= do_shortcode( sprintf( '[gravityform id="%s" title="false" description="false" ajax="true" tabindex="99"]', $form_id ) );
        }
        
        
        $output = sprintf( '<div class="column row">%s</div>', $content );
        
        // Do not change
        
        $args = array( 'id' => 'section-form', 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_form();