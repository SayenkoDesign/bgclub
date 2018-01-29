<?php
/*
Template Name: Page Builder
*/


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
 	page_builder();
	function page_builder() {
	
		global $post;
  		
		if ( have_rows('sections') ) {
		
			while ( have_rows('sections') ) { 
			
				the_row();
                
                $data = get_fields();
			
				$row_layout = str_replace( '_section', '', get_row_layout() );
                
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
