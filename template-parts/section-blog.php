<?php

/*
Section - Blog
		
*/

if( ! function_exists( 'section_blog' ) ) {
 
    function section_blog() {
                
        // Classes & Styles need to be an array
        $classes = array( 'section-blog' );
        $styles = array();
        $output = '';
              
        $prefix = 'blog';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
                      
        $blog_category 	    = $fields['blog_category'];
        $featured_story	    = $fields['featured_story'];
        $featured_post      = $fields['featured_post'];
         
          
        $story     = _get_story( $blog_category, $featured_story );
        $blog_post = _get_blog_post( $blog_category, $featured_story );
        $events    = _get_events_list();
        
        if( empty( $story ) || empty( $blog_post ) ) {
            return;
        }
        
        
        $output = sprintf( '<div class="row expanded small-collapse" data-equalizer data-equalize-on="xxlarge"><div class="xxlarge-6 columns">%s</div><div class="xxlarge-6 columns"><div class="blog-events" data-equalizer-watch>%s%s</div></div></div>', 
                            $story, $blog_post, $events );
        
        // Do not change
        
        $args = array( 'class' => $classes, 'style' => $styles );
         
        _s_section( $output, $settings, $args );
            
    }
    
}


if( ! function_exists( '_get_story' ) ) {
    function _get_story( $cat = false, $post_id = false ) {
        
        // arguments, adjust as needed
        $args = array(
            'post_type'      => 'story',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        );
        
        if( !empty( $post_id ) ) {
            
            $args['p'] = $post_id;
            
        } else {
            
            $args['orderby']    = 'RAND';
            
            if( !empty( $cat ) ) {
                $tax_query[] = array(
                    'taxonomy'         => 'category',
                    'terms'            =>  [$cat],
                    'field'            => 'term_id',   
                    'operator'         => 'IN',
                    'include_children' => false,
                );
                
                $args['tax_query'] = $tax_query;
            }       
            
        }
    
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
        
        $out = '';
    
        // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
        // don't want to use $wp_query, use our custom variable instead.
        if ( $loop->have_posts() ) : 
            while ( $loop->have_posts() ) : $loop->the_post(); 
    
                $background = get_the_post_thumbnail_url( get_the_ID(), 'large' ); 
                if( !empty( $background ) ) {
                    $background = sprintf( ' style="background-image: url(%s)"', $background );
                }
                
                $video = get_field( 'video', false, false );
                if( !empty( $video ) ) {
                    $video = youtube_embed( $video );
                    $video = sprintf( '<button class="play-video" data-open="modal-video" data-src="%s">%s</button>', $video, get_svg( 'play' ) );
                }
                
                $title = the_title( '<h2>', '</h2>', false );
                $description  = sprintf( '<div class="entry-content">%s</div>', apply_filters( 'the_content', get_the_excerpt() ) );
                $quote = sprintf( '<div class="quote">%s</div>', get_svg( 'quote' ) );
                $permalink  = sprintf( '<p><a href="%s" class="button green">%s</a></p>', get_permalink(), 'Full Story' );
                
                $out = sprintf( '<div class="story"%s data-equalizer-watch><div class="entry-title clearfix">%s%s</div>%s%s%s</div>', $background, $video, $title, $description, $quote, $permalink );
    
            endwhile;
        endif;
    
        wp_reset_postdata();
        
        return $out;
        
    }
}

if( ! function_exists( '_get_blog_post' ) ) {
    function _get_blog_post( $cat = false, $post_id = false ) {
        
        // arguments, adjust as needed
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        );
        
        if( !empty( $post_id ) ) {
            
            $args['p'] = $post_id;
            
        } else {
            
            $args['orderby']    = 'RAND';
            
            if( !empty( $cat ) ) {
                $tax_query[] = array(
                    'taxonomy'         => 'category',
                    'terms'            =>  [$cat],
                    'field'            => 'term_id',   
                    'operator'         => 'IN',
                    'include_children' => false,
                );
                
                $args['tax_query'] = $tax_query;
            }       
            
        }
    
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
        
        $out = '';
    
        // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
        // don't want to use $wp_query, use our custom variable instead.
        if ( $loop->have_posts() ) : 
            while ( $loop->have_posts() ) : $loop->the_post(); 
    
                $categories = get_the_category();
                $cat_name = '';
                $cat_link = get_permalink( get_option( 'page_for_posts' ) );;
 
                if ( ! empty( $categories ) ) {
                    $cat_name = sprintf( '<h4>%s</h4>', esc_html( $categories[0]->name ) );   
                    $cat_link = esc_url( get_category_link( $categories[0]->term_id ) );
                }
                
                
                $background = get_the_post_thumbnail_url( get_the_ID(), 'large' ); 
                if( !empty( $background ) ) {
                    $background = sprintf( '<div class="thumbnail" style="background-image: url(%s)"></div>', $background );
                }
                
                
                $title = the_title( '<h3>', '</h3>', false );
                $description  = apply_filters( 'the_content', get_the_excerpt() );
                $permalink  = sprintf( '<a href="%s" class="learn-more">%s</a>', get_permalink(), 'Read More' );
                $more       = sprintf( '<a href="%s" class="learn-more">%s</a>', $cat_link, 'More Posts' );
                $links      = sprintf( '<p class="links">%s%s</p>', $permalink, $more );
                
                $out = sprintf( '<div class="blog-post"><div class="entry-content">%s%s%s%s</div>%s</div>', $cat_name, $title, $description, $links, $background );
    
            endwhile;
        endif;
    
        wp_reset_postdata();
        
        return $out;
        
    }
}


if( ! function_exists( '_get_events_list' ) ) {
    function _get_events_list( $cat = false ) {
        
        // arguments, adjust as needed
        $args = array(
            'post_type'      => 'event',
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
            'meta_key'       => 'event_start_date'
        );
        			
        // Only show future concerts
        $meta_query = array(
            array(
                'key' => 'event_end_date',
                'value' => date_i18n('Ymd'),
                'compare' => '>='
            )
        );
        
        $args['meta_query'] = $meta_query;
        
        
        if( !empty( $cat ) ) {
            $tax_query[] = array(
                'taxonomy'         => 'category',
                'terms'            =>  [$cat],
                'field'            => 'term_id',   
                'operator'         => 'IN',
                'include_children' => false,
            );
            
            $args['tax_query'] = $tax_query;
        }       
                
        // Use $loop, a custom variable we made up, so it doesn't overwrite anything
        $loop = new WP_Query( $args );
        
        $out = sprintf( '<h2>%s</h2>', 'Upcoming Events' );
    
        // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
        // don't want to use $wp_query, use our custom variable instead.
        if ( $loop->have_posts() ) : 
        
            $out .= '<ul>';
            
            while ( $loop->have_posts() ) : $loop->the_post(); 
                
                $date = sprintf( '<span class="date">on %s</span>', get_field( 'event_start_date' ) );
                                
                $out .= sprintf( '<li><a href="%s">%s, %s</a></li>', get_permalink(), get_the_title(), $date );
    
            endwhile;
            
            $out .= '</ul>';
        else:
            $out .= sprintf( '<p>%s</p>', 'No upcoming events' );
        endif;
    
        wp_reset_postdata();
        
        $out = sprintf( '<div class="events">%s</div>', $out );
        
        return $out;
        
    }
}


section_blog();