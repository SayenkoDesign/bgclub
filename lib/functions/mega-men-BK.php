<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Main class
 *
 * @since 1.1.0
 * @package BE_Mega_Menu
 */
final class BE_Mega_Menu {

	/**
	 * Menu Location
	 *
	 * @since 1.1.0
	 */
	public $menu_location = 'primary';
    
    static $columns = 0;

	/**
	 * Plugin Constructor.
	 *
	 * @since 1.1.0
	 * @return BE_Mega_Menu
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize
	 *
	 * @since 1.1.0
	 */
	function init() {

		// Set new location
		$this->menu_location = apply_filters( 'be_mega_menu_location', $this->menu_location );

		add_action( 'init', array( $this, 'register_cpt' ), 20 );
        add_filter( 'wp_nav_menu_args', array( $this, 'add_mega_menu_class' ) );
		//add_filter( 'wp_nav_menu_args', array( $this, 'limit_menu_depth' ) );
		add_filter( 'nav_menu_css_class', array( $this, 'menu_item_classes' ), 10, 4 );
		//add_filter( 'walker_nav_menu_start_el', array( $this, 'display_mega_menus' ), 10, 4 );
        add_filter('wp_nav_menu_objects', array( $this, 'my_wp_nav_menu_objects' ), 10, 2);
        add_filter( 'walker_nav_menu_start_el', array( $this, 'be_header_menu_desc' ), 10, 4 );


	}

	/**
	 * Register Mega Menu post type
	 *
	 * @since 1.0.0
	 */
	function register_cpt() {

		$labels = array(
			'name'               => 'Mega Menus',
			'singular_name'      => 'Mega Menu',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Mega Menu',
			'edit_item'          => 'Edit Mega Menu',
			'new_item'           => 'New Mega Menu',
			'view_item'          => 'View Mega Menu',
			'search_items'       => 'Search Mega Menus',
			'not_found'          => 'No Mega Menus found',
			'not_found_in_trash' => 'No Mega Menus found in Trash',
			'parent_item_colon'  => 'Parent Mega Menu:',
			'menu_name'          => 'Mega Menus',
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions' ),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'themes.php',
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => 'megamenu', 'with_front' => false ),
			'menu_icon'           => 'dashicons-editor-table', // https://developer.wordpress.org/resource/dashicons/
		);

		register_post_type( 'megamenu', apply_filters( 'be_mega_menu_post_type_args', $args ) );

	}
    
    
    /**
	 * Add Mega Menu Class
	 *
	 * @since 1.0.0
	 * @param array $args
	 * @return array
	 */
	function add_mega_menu_class( $args ) {

		if( $this->menu_location == $args['theme_location'] )
			$args['menu_class'] .= ' mega-menu';

		return $args;
	}

    

	/**
	 * Limit Menu Depth
	 *
	 * @since 1.0.0
	 * @param array $args
	 * @return array
	 */
	function limit_menu_depth( $args ) {

		if( $this->menu_location == $args['theme_location'] )
			$args['depth'] = 1;

		return $args;
	}

	/**
	 * Menu Item Classes
	 *
	 * @since 1.1.0
	 * @param array $classes
	 * @param object $item
	 * @param object $args
	 * @param int $depth
	 * @return array
	 */
	function menu_item_classes( $classes, $item, $args, $depth ) {

		if( $this->menu_location != $args->theme_location )
			return $classes;

		$menu_item = get_field( 'mega_menu', $item );
                
        if( 'Parent' == $menu_item['mega_menu_item'] ) {
            $classes[] = 'mega-menu-item';
        }

		return $classes;
	}

	/**
	 * Display Mega Menus
	 *
	 * @since 1.0.0
	 * @param string $item_output
	 * @param object $item
	 * @param int $depth
	 * @param object $args
	 * @return string
	 */
	function display_mega_menus( $item_output, $item, $depth, $args ) {
        
        if( ! ( $this->menu_location == $args->theme_location ) )
			return $item_output;

		
        $indent = str_repeat("\t", $depth);
        
        $menu_item = get_field( 'mega_menu', $item );
        
        //var_dump( $menu_item );
        
        if( 'Column' == $menu_item['mega_menu_item'] ) {
            $item_output = str_replace( '<ul class="sub-menu">', '<ul class="sub-menu"><ul class="mega-sub-menu">', $item_output );
        }
        
        

		return $item_output;
	}
    
    
    
    // Add mega menu post to menu item
    public function my_wp_nav_menu_objects( $items, $args ) {
        
        // loop
        foreach( $items as &$item ) {
            
            // Needs to have a parent menu item
            if( false == $item->post_parent ) {
                continue;   
            }
            
            $parent_menu_item = get_field( 'mega_menu', $item->post_parent );
                    
            // Parent needs to be a mega menu parent
            if( 'Parent' == $parent_menu_item ) {
                continue;
            }
            
            $menu_item = get_field( 'mega_menu', $item );
            
            // var_dump( $menu_item );
            
            $menu_item_content = $menu_item['menu_item_content'];
                                    
            if( is_wp_error( $menu_item_content ) || ! is_object( $menu_item_content ) ) {
                continue;
            }
        
            $opening_markup = apply_filters( 'be_mega_menu_opening_markup', '<div class="mega-menu-post-content">' );
            $closing_markup = apply_filters( 'be_mega_menu_closing_markup', '</div>' );
            
            $content = '';
                        
            // Featured Image?
            if( has_post_thumbnail( $menu_item_content ) ) {
                $thumbnail = get_the_post_thumbnail( $menu_item_content, 'medium' );
                $content .= sprintf( '<div class="mega-menu-thumbnail" data-photo="%s">%s</div>', esc_html( $thumbnail ), $thumbnail );
            }
            
            $content .= apply_filters( 'the_content', $menu_item_content->post_content );
            $content = $opening_markup . $content . $closing_markup;
            
            $item->description = $content;
            
        }
        
        
        // return
        return $items;
        
    }
    
    
    // Output mega menu description to menu item
    public function be_header_menu_desc( $item_output, $item, $depth, $args ) {
        
        if( ! ( $this->menu_location == $args->theme_location ) )
			return $item_output;
        
        if( $item->description )
            $item_output = $item->description;
            
        return $item_output;
    }

	
}
new BE_Mega_Menu;




class Mega_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * @see Walker::$tree_type
	 */
	var $tree_type = array('mega_menu');

	/**
	 * @see Walker::$db_fields
	 */
	var $db_fields = array(
		'parent' => 'parent_id',
		'id' => 'ID',
	);

	/**
	 * Overrides Walker_Nav_Menu::start_el() to display some of our special stuffs.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @see Walker::start_el()
	 * @see Walker::walk()
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		global $post;

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-depth-' . $depth;

		// if this is the currently active page, OR if $depth is 0 and this item is stored as an
		// active page
		if($item->post_id == $post->ID || (in_array($item->ID, Mega_Menu::$active_pages) && $depth == 0)) {
			$classes[] = 'active';
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$item_output = '';
		if ($item->post_id || isset($item->url)) {
			if ($item->post_id) {
				$url = get_permalink($item->post_id);
			} else {
				$url = $item->url;
			}

			$attributes = '';
			$attributes .= ! empty($url)               ? ' href="'   . esc_attr($url            ) .'"' : '';
			$attributes .= ! empty($item->attr_title)  ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
			$attributes .= ! empty($item->target)      ? ' target="' . esc_attr($item->target   ) .'"' : '';
			$attributes .= ! empty($item->xfn)         ? ' rel="'    . esc_attr($item->xfn      ) .'"' : '';

			$item_output = '<a'. $attributes .'>' . $args->link_before . apply_filters('the_title', $item->post_title, $item->ID) . $args->link_after . '</a>';
		} else if ($item->type == 'shortcode') {
			$item_output = do_shortcode(htmlspecialchars_decode($item->post_title, ENT_QUOTES));
		} else if (isset($item->post_title)) {
			$item_output = '<span>'.$item->post_title.'</span>';
		}

		$item_output = $args->before . $item_output . $args->after;

		if(!empty($args->mega_wrapper) && $depth == 0) {
			$item_output .= $args->mega_wrapper;
		}

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= apply_filters('walker_nav_menu_end_el', '', $item, $depth, $args);
		if(!empty($args->mega_wrapper_end) && $depth == 0) {
			$output .= $args->mega_wrapper_end;
		}
		parent::end_el($output, $item, $depth, $args);
	}
}