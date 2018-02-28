<?php
// Numbers Section

if( ! function_exists( 'section_numbers' ) ) {

    function section_numbers() {
                
         // Classes & Styles need to be an array
        $classes = array( 'section-numbers' );
        $styles = array();
        $output = '';
        
        
        $prefix = 'number';
        $prefix = set_field_prefix( $prefix );
           
        // Number Grid
        $grid_items = get_sub_field( sprintf( '%sgrid', $prefix ) );
        if( !empty( $grid_items ) ) {
            foreach( $grid_items as &$grid_item ) {
                 $grid_item['grid_button'] = '';
             }
        }
        
                
        $fg         = new Foundation_Grid( array( 'echo' => false  ) );
        $grid       = $fg->generate( $grid_items ); 
        
        $button     = get_sub_field( sprintf( '%sbutton', $prefix ) );
        
                
        if( !empty( $button ) ) {
            $button = sprintf( '<div class="column row"><p class="text-center">%s</p></div>', pb_get_cta_button( $button, array( 'class' => 'button blue' ) ) );
        }  
                
        $settings = get_sub_field( 'grid_settings' );
        
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = $section['description'];
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $output   .= sprintf( '<div class="column row"><header class="entry-header">%s%s</header></div>', 
                        $heading, $description );
        }   
        
        $output .= $grid;   
        
        $output .= $button;

                
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        _s_section( $output, $settings, $args );
        
            
    }

}

section_numbers();
