<?php

/*
Section - Panel
		
*/

if( ! function_exists( 'section_panel' ) ) {
 
    function section_panel() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-panel' );
        $styles = array();
        $output = '';
              
        $prefix = 'panel';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $heading 		    = $fields['heading'];
        $editor	            = $fields['editor'];
        $buttons            = $fields['buttons'];
         
          
        $content = '';
        
        $content = sprintf( '<div class="logo-mark">%s</div>', get_svg( 'logo-mark' ) );
        
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $content   .= sprintf( '<div class="column row"><header class="entry-header">%s%s</header></div>', 
                        $heading, $editor );
        }  
        
        
        $button_group = '';
        if( !empty( $buttons ) ) {

            foreach( $buttons as $key => $button ) {
                 $button_group .= pb_get_cta_button( $button['button'], array( 'class' => 'button green-alt' ) ); 
            }
            
            $content .= sprintf( '<p class="button-group">%s</p>', $button_group );
        }
           
                 
        $content = sprintf( '<div class="entry-content">%s</div>', $content );
        
        
        $output = sprintf( '<div class="column row">%s</div>', $content );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}

section_panel();
    