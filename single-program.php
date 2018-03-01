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
    get_template_part( 'template-parts/hero', 'program' );
    
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
