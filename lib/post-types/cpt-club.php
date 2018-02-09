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
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
			)

        );
		
		
     }
	 
	 
 
}

new CPT_Club();
