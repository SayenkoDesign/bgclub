<?php

// Add modals to footer
function _s_footer() {
    
    get_template_part( 'template-parts/modal', 'video' );   
    get_template_part( 'template-parts/modal', 'contact' );   
}
add_action( 'wp_footer', '_s_footer' );


// Make sure attachments don't conflict with post type permalinks
//add_filter( 'wp_unique_post_slug', '_s_unique_post_slug', 10, 6 );
function wpse17916_unique_post_slug( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
  
    global $wp_post_types;
    $post_types = [];
    foreach ( $wp_post_types as $type ) {
        if( isset( $type->rewrite['slug'] ) ) {
            $post_types[] = $type->rewrite['slug'];
        }
    }
    
    if( empty( $post_types ) ) {
        return $slug;
    }
      
    if ( 'attachment' == $post_type ) {
        if( in_array( $original_slug, $post_types ) ) {
            $slug = $original_slug . uniqid( '-' );
        }
    }
    
    return $slug;
}

