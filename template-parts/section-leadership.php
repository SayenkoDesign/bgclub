<?php
// Leadership Section

if( ! function_exists( 'section_leadership' ) ) {

    function section_leadership() {
                
        
        // Classes & Styles need to be an array
        $classes = array( 'section-leadership' );
        $styles = array();
        $output = '';
        
        $prefix = 'leadership';
        $prefix = set_field_prefix( $prefix );
            
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = $section['description'];
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            $output   .= sprintf( '<div class="column row"><header class="entry-header">%s</header>%s</div>', 
                        $heading, $description );
        }   
        
        $staff_heading = get_sub_field( 'staff_heading' );
        if( empty( $staff_heading ) ) {
            $staff_heading = 'Staff';
        }
        
        $staff_heading    = _s_get_heading( $staff_heading, 'h3' );
        
        $staff_items = get_sub_field( 'staff_staff' );
        
        // Array ( [0] => Array ( [staff_photo] => 224 [staff_name] => [staff_position] => [staff_email] => [staff_phone] => ) )
        
        if( !empty( $staff_items ) ) {
            
            $output .= $staff_heading;
            
            $staff = '';
            
            foreach( $staff_items as $member ) {
                $photo = ! empty(  $member['staff_photo'] ) ? _s_get_acf_image( $member['staff_photo'], 'thumbnail' ) : '';
                $name = ! empty(  $member['staff_name'] ) ? _s_get_heading( $member['staff_name'], 'h3' ) : '';
                $position = ! empty(  $member['staff_position'] ) ? sprintf( '<h6>%s</h6>', $member['staff_position'] ) : '';
                
                $email = ! empty(  $member['staff_email'] ) ? sprintf( '<p><a href="mailto:%1$s">%1$s</a></p>', 
                                   antispambot( $member['staff_email'] ) ) : '';
                $phone = ! empty(  $member['staff_phone'] ) ? sprintf( '<p><a href="%s">%s</a></p>', 
                                   _s_format_telephone_url( $member['staff_phone'] ), $member['staff_phone'] ) : '';
                                   
                $staff .= sprintf( '<div class="column">%s<div class="details">%s%s%s%s</div></div>', 
                                   $photo, $name, $position, $email, $phone );                    
            }
            
            $output .= sprintf( '<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-5">%s</div>', $staff );
        }
        
        
        $board_heading = get_sub_field( 'board_heading' );
        if( empty( $board_heading ) ) {
            $staff_heading = 'Board';
        }
        $board_heading    = _s_get_heading( $board_heading, 'h3' );
        
        $board_items = get_sub_field( 'board_list' );
        
        if( !empty( $board_items ) ) {
            
            $output .= $board_heading;
            
            $board_items = wp_list_pluck( $board_items, 'list_title' );
            
            foreach( $board_items as &$item ) {
                $item = sprintf( '<p>%s</p>', $item );
            }
            
            // Columns
            if( count( $board_items ) > 24 ) {
                $columns = 4;
            }
            else if( count( $board_items ) > 12 ) {
                $columns = 3;
            }
            /*else if( count( $board_items ) > 6 ) {
                $columns = 2;
            }*/
            else {
                $columns = 2;   
            }
            
            $column_classes = array( 
                                     1 => '', 
                                     2 => ' medium-up-2', 
                                     3 => ' large-up-3', 
                                     4 => ' medium-up-2 large-up-4', );
            
            $board_items = c2c_array_partition( $board_items, $columns );
            $board_columns = '';
            foreach( $board_items as $array => $column ) {
                $board_columns .= sprintf( '<div class="column">%s</div>', join( '', $column ) );
            }
            
            $output .= sprintf( '<div class="row small-up-1%s">%s</div>', $column_classes[$columns], $board_columns );
        }
            
        $settings = get_sub_field( 'leadership_settings' );
        
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
        
        _s_section( $output, $settings, $args );
    }

}

section_leadership();
