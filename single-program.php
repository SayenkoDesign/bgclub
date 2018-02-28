<?php
/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function kr_body_class( $classes ) {
  $classes[] = 'page-builder';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class' );

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
     
	<?php
    // Add Hero
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
         
         printf( '<div class="wave-bottom show-for-medium">%s</div>', get_svg( 'wave-bottom' ) );
    }
    
    
    // Add top section
    program_menu();
    function program_menu() {
        
        // Icon
        
        // Previous/Next links
        
        
        $attr = array( 'id' => 'program-menu', 'class' => 'section-program-menu' );        	
        
        _s_section_open( $attr );	
           
        $previous = sprintf( '%s<span class="%s"></span>', 
                                         get_svg( 'arrow' ), __( 'Previous Post', '_s') );
                    
        $next = sprintf( '%s<span class="%s"></span>', 
                             get_svg( 'arrow' ), __( 'Next Post', '_s') );
                             
        $icon = get_field( 'icon' );
        
        if( !empty( $icon ) ) {
            printf( '<div class="program-icon"><span>%s</span></div>', _s_get_acf_image( $icon ) );
        }
        
        printf( '<div class="column row">%s</div>', get_the_post_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) ) );
        
        _s_section_close();
        
    }
    
    
 	page_builder();
	function page_builder() {
	
		global $post;
        
        // Cache meta, helps speed things up a little
        $meta = get_post_meta( $post->ID );
        
        $data = array();
          		
		if ( have_rows('sections') ) {
		
			while ( have_rows('sections') ) { 
			
				the_row();
                			
				$row_layout = str_replace( '_section', '', get_row_layout() );
                
                // Let's set allowed club sections
                
                // Use custom template part function so we can pass data
                _s_get_template_part( 'template-parts/section', $row_layout, array( 'data' => $data ) );
  					
			} // endwhile have_rows('sections')
			
 		
		} // endif have_rows('sections')
	
	
	}
		
	?>
    
 
    
    
	</main>


</div>

<?php
get_footer();
