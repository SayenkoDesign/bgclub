<?php
 
/**
 * Create new CPT - Story
 */
 
class CPT_Story extends CPT_Core {

    const POST_TYPE = 'bg_story';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Story', self::TEXTDOMAIN ), // Singular
				__( 'Storys', self::TEXTDOMAIN ), // Plural
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
				'rewrite'             => array( 'slug' => 'storys' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ),
				 )

        );
		
              
             add_action('init', array( $this, 'add_tags' ));

     }
	     
    
    function add_tags(){
        register_taxonomy_for_object_type('post_tag', 'bg_story');
    }

 
}

new CPT_Story();


$story_categories = array(
    __( 'Story Category', CPT_Story::TEXTDOMAIN ), // Singular
    __( 'Story Categories', CPT_Story::TEXTDOMAIN ), // Plural
    'story_cat' // Registered name
);

register_via_taxonomy_core( $story_categories, 
	array(
		'hierarchical' => true,
        'show_in_nav_menus'   => false,
        'rewrite' => array( 'slug' => 'story-categories' ),
	), 
	array( CPT_Story::POST_TYPE ) 
);
