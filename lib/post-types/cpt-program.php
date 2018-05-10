<?php
 
/**
 * Create new CPT - Program
 */
 
class CPT_Program extends CPT_Core {

    const POST_TYPE = 'program';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Program', self::TEXTDOMAIN ), // Singular
				__( 'Programs', self::TEXTDOMAIN ), // Plural
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
				'rewrite'             => array( 'slug' => 'programs' ),
				'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'author' ),
			)

        );
		
		
        add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );
        
     }
	 
	 
     function pre_get_posts($query) {
						
		if ( $query->is_main_query() && is_post_type_archive( self::POST_TYPE ) && !is_admin() ) {
			
            $terms = array();
            											
			$query->set('posts_per_page', '-1' );
			
			// Order By
			$query->set( 'orderby', 'menu_order title' );
			$query->set( 'order', 'ASC' );
            
            // Exclude posts from main query that have a term selected
			$query->set( 'tax_query', array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'program_cat',
                'field' => 'id',
                'terms' => get_terms('program_cat', array(
                    'fields' => 'ids'
                )),
                'operator' => 'NOT IN'
            )
        ) );
		
		}
			
		return $query;
	}    
 
}

new CPT_Program();


$program_categories = array(
    __( 'Program Category', CPT_Event::TEXTDOMAIN ), // Singular
    __( 'Programs Categories', CPT_Event::TEXTDOMAIN ), // Plural
    'program_cat' // Registered name
);

register_via_taxonomy_core( $program_categories, 
	array(
		'hierarchical' => true,
        'show_in_nav_menus'   => false,
        'rewrite' => false,
	), 
	array( CPT_Program::POST_TYPE ) 
);
