<?php
 
/**
 * Create new CPT - Club
 */
 
class CPT_Club extends CPT_Core {

    const POST_TYPE = 'club';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Club', self::TEXTDOMAIN ), // Singular
				__( 'Clubs', self::TEXTDOMAIN ), // Plural
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
				'rewrite'             => array( 'slug' => 'clubs' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions', 'author' ),
			)

        );
		
        add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );
		
     }
	 
     function pre_get_posts($query) {
						
		if ( $query->is_main_query() && is_post_type_archive( self::POST_TYPE ) && !is_admin() ) {
			            											
			$query->set('posts_per_page', '-1' );
		
		}
			
		return $query;
	}    
     
     /**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $columns Array of registered column names/labels
	 * @return array           Modified array
	 */
	public function columns( $columns ) {
		$new_column = array(
			'club_id' => 'Club ID',
		);
		return array_insert_after( $columns, 2, $new_column );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $column Array of registered column names
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
			case 'club_id':
				the_ID();
				break;
		}
	}
	 
 
}

new CPT_Club();
