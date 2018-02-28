<?php
// Team Current Openings

if( ! function_exists( 'section_current_opening' ) ) {

    function section_current_opening() {
                
        
        // Classes & Styles need to be an array
        $classes = array( 'section-current-openings' );
        $styles = array();
        $output = '';
        
        $prefix = 'current_opening';
        $prefix = set_field_prefix( $prefix );
                        
        
        $current_opening_items = get_sub_field( 'current_openings_grid' );
                        
        $fg = new Foundation_Grid( array( 'format' => 'block', 
                                         'class' => 'row small-up-1 medium-up-2 large-up-4', 'echo' => false  ) );
                                         
        $current_opening = $fg->generate( $current_opening_items ); 
        
            
        $settings = get_sub_field( 'current_opening_settings' );
          
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = $section['description'];
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $output   .= sprintf( '<div class="column row"><header class="entry-header">%s%s</header></div>', 
                        $heading, $description );
        }   
        
        $output .= $current_opening;   
        
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        _s_section( $output, $settings, $args );
    }

}

section_current_opening();
