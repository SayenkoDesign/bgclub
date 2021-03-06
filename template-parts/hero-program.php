<?php

hero();
function hero() {
    
    $fields = get_field( 'hero' );
          
    $heading = $fields['heading'];
    
    $background_image       = $fields['background_image'];
    $background_position_x  = $fields['background_position_x'];
    $background_position_y  = $fields['background_position_y'];
    $hero_overlay           = $fields['overlay'];
    $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
            
    $style = '';
    $content = '';
     
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $style = sprintf( 'background-image: url(%s);', $background[0] );
        
        if( !empty( $style ) ) {
            $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
        }
    }
    
    
    if( !empty( $heading ) ) {
        $content .= _s_get_heading( $heading, 'h1' );
    }
            
    $attr = array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style );
    
    $attr['class'] .= $hero_overlay;
        
    
    _s_section_open( $attr );	
       
    printf( '<div class="column row"><div class="entry-content">%s</div></div>', $content );
    
     _s_section_close();
     
     printf( '<div class="wave-bottom">%s</div>', get_svg( 'wave-bottom' ) );
}