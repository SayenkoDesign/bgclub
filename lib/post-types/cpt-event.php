<?php
 
/**
 * Create new CPT - Event
 */
 
class CPT_Event extends CPT_Core {

    const POST_TYPE = 'event';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Event', self::TEXTDOMAIN ), // Singular
				__( 'Events', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array( 
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'post',
				'has_archive'         => true,
				'hierarchical'        => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => false,
				'rewrite'             => array( 'slug' => 'events' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
				 )

        );
		
			 add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );
             
             add_action('init', array( $this, 'add_tags' ));

     }
	 

    function pre_get_posts($query) {
						
		if ( $query->is_main_query() && is_post_type_archive( self::POST_TYPE ) ) {
														
			$query->set('posts_per_page', '-1' );
			
			// Order By
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'ASC' );
			$query->set( 'meta_key', 'event_start_date' );
			
			// Only show future concerts
			$meta_query = array(
				array(
					'key' => 'event_end_date',
					'value' => date_i18n('Ymd'),
					'compare' => '>='
				)
			);
			
		    $query->set( 'meta_query', $meta_query );
		
		}
			
		return $query;
	}    
    
    function add_tags(){
        register_taxonomy_for_object_type('post_tag', 'bg_event');
    }

 
}

new CPT_Event();


$event_categories = array(
    __( 'Event Category', CPT_Event::TEXTDOMAIN ), // Singular
    __( 'Event Categories', CPT_Event::TEXTDOMAIN ), // Plural
    'event_cat' // Registered name
);

register_via_taxonomy_core( $event_categories, 
	array(
		'hierarchical' => true,
        'show_in_nav_menus'   => false,
        'rewrite' => array( 'slug' => 'event-categories' ),
	), 
	array( CPT_Event::POST_TYPE ) 
);
