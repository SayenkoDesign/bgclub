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
    get_template_part( 'template-parts/hero', 'club' );

    
    
    // Add top section
    intro();
    function intro() {
                
        
        $location = [];
        
        $fields = array( 'address', 'email', 'phone', 'hours', 'grades_served', 'register', 'map_marker' );
        
        extract( $fields );
        
        foreach( $fields as $field ) {
            
            $data = get_field( $field );
            
            if( !empty( $data ) ) {
                
                if( 'map_marker' == $field ) {
                    $location['lat'] = $data['lat']; 
                    $location['lng'] = $data['lng']; 
                    $url = wp_is_mobile() ? 'place' : 'dir';
                    $location['directions'] = sprintf( 'https://www.google.com/maps/%s/%s', $url, urlencode( $data['address'] ) );
                }
                                
                if( ! is_array( $data ) ) {
                    $location[$field] = $data;
                }
            }
             
        }
        
        $social_icons = array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube' );
        $profiles = [];
        foreach( $social_icons as $icon ) {
            $profiles[$icon] = get_field( $icon );
        }
                
        $social = _s_get_social_icons( $profiles );
        
        $location['address'] = nl2br( $location['address'] );
        
        $content = '';
        
        $content = _s_get_textarea( $location['address'], 'p', array( 'class' => 'location' ) );
        
        $content .= sprintf( '<p><a href="%s" class="arrow">%s</a></p>', $location['directions'], 'Get Directions' );
        
        $content .= sprintf( '<p><a href="%s" class="tel">%s %s</a></p>', _s_format_telephone_url( $location['phone'] ), 'Call Us', $location['phone'] );
        
        $content .= $social;
        $left = sprintf( '<div class="small-12 large-6 columns">%s</div>', $content );
        
        $content = sprintf( '<p><strong>Hours</strong>%s</p>', $location['hours'] );
        $content .= sprintf( '<p><strong>Grades Served</strong>%s</p>', $location['grades_served'] );
        $right = sprintf( '<div class="small-12 large-6 columns">%s</div>', $content );
        
        $left = sprintf( '<div class="row">%s%s</div>', $left, $right );
        
        $left = sprintf( '<div class="small-12 medium-6 large-8 columns">%s</div>',  $left );
        
        $content = sprintf( '<p><a href="%s" class="button green">%s</a></p>', '#club-contact', 'Message Us' );
        $content .= sprintf( '<p><a href="%s" class="button green">%s</a></p>', _s_format_telephone_url( $location['phone'] ), 'Call Us' );
        $right = sprintf( '<div class="small-12 medium-6 large-4 columns">%s</div>',  $content );
        
        $attr = array( 'id' => 'club-intro', 'class' => 'section-intro' );        	
        
        _s_section_open( $attr );	
           
        printf( '<div class="column row"><div class="box"><div class="row">%s%s</div></div></div>', $left, $right );
        
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
