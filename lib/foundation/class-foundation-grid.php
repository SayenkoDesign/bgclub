<?php

// Foundation Accordion


class Foundation_Grid extends Foundation {
    
    /**
	 * Holds settings defaults, populated in constructor.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $defaults;
    
    
    /**
	 * Holds settings
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $settings;
    
    
    private $grid_items = array();
    
    
    public function __construct( $settings = array() ) {
        parent::__construct();
        
        $this->defaults = array(
            'image_size' => 'large',
            'title_position' => 'after',
            'title_tag' => 'h3',
            'class' => 'row small-up-1 large-up-3',
            'format' => 'item', // item (has link/button)| block (entire item is clickable)
            'return' => 'string', //string|array
            'echo' => false
		);
        
        $this->settings = wp_parse_args( $settings, $this->defaults );
        
	}
    
    
    public function generate( $rows ) 
    {
        if( empty( $rows ) ) {
            return false;
        }
        
        extract( $this->settings );
        
        // Let's cache the media
        foreach ($rows as $row) {
            if( isset( $row['photo'] ) && !empty( $row['photo'] ) )
            $ids[] = $row['photo'];
        }
        
        if( !empty( $ids ) ) {
            $cache = get_posts(array('post_type' => 'attachment', 'numberposts' => -1, 'post__in' => $ids));
        }
        
        $grid = '';
        
        $grid_items = array();
                
        foreach( $rows as $row ) {
                    
            $photo = isset(  $row['grid_photo'] ) ? $row['grid_photo']: '';
                    
            if( $photo ) {
                
                if( wp_is_mobile() ) {
                    $image_size = 'thumbnail';
                }
                
                $photo = sprintf( '<div class="thumbnail">%s</div>', wp_get_attachment_image( $photo, $image_size ) );
            }
            
            $title = !empty(  $row['grid_title'] ) ? sprintf( '<%1$s>%2$s</%1$s>', $title_tag, $row['grid_title'] ) : '';
            $title_before = $title_after = $title;
            if( $title_position == 'before' ) {
                $title_after = '';
            } else {
                $title_before = '';
            }
            
            $description = isset(  $row['grid_description'] ) ? $row['grid_description']: '';
            
            $button = $row['grid_button'];

            $anchor_open = $anchor_close = '';
            
            if( 'block' == $format ) {
                
                if ( $button['link'] == 'Page' ) {
                    if ( ! empty( $button['page'] ) ) {
                        $url = $page;
                    }
                } 
                else if( $button['link'] == 'Absolute URL' ) {
                    if ( ! empty( $button['url'] ) ) {
                        $url = $button['url'];
                    }
                }
                else {
                    $url = '';   
                }
                
                if( !empty( $url ) ) {
                    $anchor_open = sprintf( '<a href="%s">', $url );
                    $anchor_close = '</a>';
                    $button = sprintf( '<p><span class="more">%s</span></p>', $button['text'] );
                }
            }
             
            $grid_items[] = sprintf( '<div class="column">%s%s%s%s%s%s%s</div>', 
                                     $anchor_open, $title_before, $photo, $title_after, $description, $button, $anchor_close );
        }
        
        if( empty( $grid_items ) ) {
            return;   
        }
        
        if( 'array' == $return ) {
            return $grid_items;
        }
        
        $grid = sprintf( '<div class="%s">%s</div>', $class, join( '', $grid_items ) );
        
        if( $echo ) {
            echo $grid;
        }
        
        return $grid;
        
    }
    
   
}