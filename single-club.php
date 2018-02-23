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
        
        $content .= sprintf( '<p><a href="%s">%s %s</a></p>', _s_format_telephone_url( $location['phone'] ), 'Call Us', $location['phone'] );
        
        $content .= $social;
        $left = sprintf( '<div class="large-6 columns">%s</div>', $content );
        
        $content = sprintf( '<p><strong>Hours</strong>%s</p>', $location['hours'] );
        $content .= sprintf( '<p><strong>Grades Served</strong>%s</p>', $location['grades_served'] );
        $right = sprintf( '<div class="large-6 columns">%s</div>', $content );
        
        $left = sprintf( '<div class="row">%s%s</div>', $left, $right );
        
        $left = sprintf( '<div class="large-8 columns">%s</div>',  $left );
        
        $content = sprintf( '<p><a href="%s" class="button green">%s</a></p>', '#send-message', 'Message Us' );
        $content .= sprintf( '<p><a href="%s" class="button green">%s</a></p>', _s_format_telephone_url( $location['phone'] ), 'Call Us' );
        $right = sprintf( '<div class="large-4 columns">%s</div>',  $content );
        
        $attr = array( 'id' => 'club-intro', 'class' => 'section intro' );        	
        
        _s_section_open( $attr );	
           
        printf( '<div class="column row">%s%s</div>', $left, $right );
        
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
