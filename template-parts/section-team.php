<?php
// Team Section

if( ! function_exists( 'section_team' ) ) {

    function section_team() {
                
        
        // Classes & Styles need to be an array
        $classes = array( 'section-team' );
        $styles = array();
        $output = '';
        
        $prefix = 'team';
        $prefix = set_field_prefix( $prefix );
                        
        
        $team_items = get_sub_field( 'team_grid' );
        
                
        $fg         = new Foundation_Grid( array( 'format' => 'block', 
                                                 'class' => 'row small-up-1 medium-up-2 large-up-4', 'echo' => false  ) );
                                                 
        $team       = $fg->generate( $team_items ); 
        
            
        $settings = get_sub_field( 'team_settings' );
          
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = $section['description'];
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $output   .= sprintf( '<div class="column row"><header class="entry-header">%s%s</header></div>', 
                        $heading, $description );
        }   
        
        $output .= $team;   
        
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        _s_section( $output, $settings, $args );
    }

}

section_team();
