<?php
// FAQ Section

if( ! function_exists( 'section_faq' ) ) {

    function section_faq() {
                
        $prefix = 'faq';
        $prefix = set_field_prefix( $prefix );
        
                
        // Heading/Description
        $section = get_sub_field( sprintf( '%ssection', $prefix ) );
        $heading = $section['heading'];
        $description = _s_get_textarea( $section['description'] );
        
        $rows = get_sub_field( 'faq_accordion' );
        
        if( empty( $rows ) ) {
            return false;
        }
        
        $settings = get_sub_field( 'faq_settings' );
                
        $fa = new Foundation_Accordion;
        
        $columns = '';
        
        foreach( $rows as $key => $row ) {
            $active = ! $key ? true : false;
            $fa->add_item( $row['heading'], $row['content'], $active );
        }
        
        $accordion_items = $fa->accordion_items;
                
        $attr = array( 'id' => 'faq', 'class' => 'section faq' );        
          
        _s_section_open( $attr );	
                  
        if( !empty( $heading ) ) {
            $heading    = _s_get_heading( $heading );
            printf( '<div class="column row"><header class="entry-header">%s%s</header></div>', $heading, $description );
        }
           
        print( '<div class="entry-content">' );
                
        if( count( $accordion_items ) > 1 ) {
            $accordion_group = c2c_array_partition( $accordion_items, 2 );
            
            foreach( $accordion_group as $group ) {
                $accordion = $fa->get_accordion( $group );
                $columns .= sprintf( '<div class="column">%s</div>', $accordion );
            }
            
            printf( '<div class="row small-up-1 large-up-2">%s</div>', $columns );
        }
        else {
            $accordion = $fa->get_accordion();
            printf( '<div class="column row">%s</div>', $accordion );
        }
        
        print( '</div>' );
    
        
        
        _s_section_close();	
        
        
        
        
           
    }

}

section_faq();
