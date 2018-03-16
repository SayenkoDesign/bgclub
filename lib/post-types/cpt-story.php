<?php
 
/**
 * Create new CPT - Story
 */
 
class CPT_Story extends CPT_Core {

    const POST_TYPE = 'story';
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
				__( 'Stories', self::TEXTDOMAIN ), // Plural
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
				'rewrite'             => array( 'slug' => 'stories' ),
				'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
                'menu_position' => 5
				 )

        );
		        
        add_action( 'save_post', array( $this, 'save_default_category' ), 10, 3 );
      
        add_action('init', array( $this, 'add_tags' ) );

     }
     
     
     public function save_default_category( $post_id, $post, $update ) {
        
        if ( self::POST_TYPE == $post->post_type ) { // replace `cpt` with your custom post type slug
            /**
             * Replace `taxo` by the taxonomy slug you want to control/set
             * … and replace `default-term` by the default term slug (or name)
             * (or you can use a `get_option( 'my-default-term', 'default term' )` option instead, which is much better)
             */
            if ( empty( wp_get_post_terms( $post_id, 'category' ) ) ) {
                wp_set_object_terms( $post_id, 1, 'category' );
            }
        }
    }


	 
     
    
    
    public function add_tags(){
        register_taxonomy_for_object_type('post_tag', self::POST_TYPE );
        register_taxonomy_for_object_type('category', self::POST_TYPE );
    }

 
}

new CPT_Story();