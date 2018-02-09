<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<?php
// Hero

archive_hero();
function archive_hero() {
        
    $post_id = 'options';    
    

    $fields = get_field( 'club_archive', 'options' );
    
    if( empty( $fields ) ) {
        return;
    }
          
    $heading 		= $fields['heading'];
    $description	= $fields['description'];
    
    $background_image       = $fields['background_image'];
    $background_position_x  = $fields['background_position_x'];
    $background_position_y  = $fields['background_position_y'];
    $hero_overlay           = $fields['overlay'];
    $hero_overlay           = $hero_overlay ? ' hero-overlay' : '';
        
    $style = '';
    $content = '';
     
    if( !empty( $background_image ) ) {
        $attachment_id = $background_image;
        $size = 'hero';
        $background = wp_get_attachment_image_src( $attachment_id, $size );
        $style = sprintf( 'background-image: url(%s);', $background[0] );
        
        if( !empty( $style ) ) {
            $style .= sprintf( ' background-position: %s %s;', $background_position_x, $background_position_y );
        }
    }
    
    
    if( !empty( $heading ) ) {
        $content .= _s_get_heading( $heading, 'h1' );
    }
    
    
    if( !empty( $description ) ) {
        $description = _s_wrap_text( $description, "\n" );
        $description = _s_get_heading( nl2br( $description ), 'h3' );
        $content .= $description;
     }

    $attr = array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style );
    
    $attr['class'] .= $hero_overlay;
        
    
    _s_section_open( $attr );	
       
    printf( '<div class="column row"><div class="entry-content">%s</div></div>', $content );
    
     _s_section_close();
     
     printf( '<div class="wave-bottom show-for-medium">%s</div>', get_svg( 'wave-bottom' ) );
        
}

?>

<div class="column row">

     <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
            <?php
             
            if ( have_posts() ) : ?>
    
               <div class="row small-up-1 large-up-3">
               
               <?php
                while ( have_posts() ) :
    
                    the_post();
                    
                    
                    printf( '<article id="post-%s" class="%s">', get_the_ID(), join( ' ', get_post_class() ) );
    
                   
                    
                    echo '</article>';
    
                endwhile;
                
                ?>
                </div>
                <?php
                
             else :
    
                get_template_part( 'template-parts/content', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>
  
</div>

<?php
get_footer();
