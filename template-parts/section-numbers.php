<?php
// Numbers Section

if( ! function_exists( 'section_grid' ) ) {

    function section_grid() {
                
         // Classes & Styles need to be an array
        $classes = array( 'section-numbers' );
        $styles = array();
        $output = '';
        
        
        $prefix = 'numbers';
        $prefix = set_field_prefix( $prefix );
           
        // Number Grid
        $grid_items = get_sub_field( 'number_grid' );
        
                
        $fg         = new Foundation_Grid( array( 'echo' => false  ) );
        $grid       = $fg->generate( $grid_items ); 
        
        $button = get_sub_field( sprintf( '%sbutton', $prefix ) );
        
        if( !empty( $button ) ) {
            $button = sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button secondary' ) ) );
        }  
                
        $settings = get_sub_field( 'grid_settings' );
        
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = $section['description'];
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $output   .= printf( '<div class="column row"><header class="entry-header">%s</header>%s</div>', 
                        $heading, $description );
        }   
        
        $output .= $grid;   

                
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        _s_section( $output, $settings, $args );
        
            
    }

}

section_grid();
