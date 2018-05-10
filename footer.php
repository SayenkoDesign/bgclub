<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?>

</div><!-- #content -->

<?php
get_template_part( 'template-parts/section', 'footer-cta' );
  
?>


<div class="footer-widgets">

<?php
printf( '<div class="wave-bottom show-for-medium">%s</div>', get_svg( 'wave-bottom' ) );

// $facebook = get_option( 'options_facebook' );
 
 ?>

    <div class="wrap">
        <div class="row">
        
            <div class="small-12 large-4 large-push-4 columns">
            
            <?php
            $logo = sprintf('<img src="%slogo-footer.svg" width="171px" height="91px" />', trailingslashit( THEME_IMG ) );
            printf( '<div class="widget widget-one"><h3>Great Futures Start Here.</h3>%s</div>',  $logo );
            ?>
            </div>
            
            <div class="small-12 large-4 large-pull-4 columns">
            <?php
            // Social Icons
            if( function_exists( '_s_get_social_icons' ) ) {
                
                $social_profiles = array( 
                      'facebook' => _s_get_acf_option( 'facebook' ),
                      'twitter' => _s_get_acf_option( 'twitter' ),
                      'instagram' => _s_get_acf_option( 'instagram' ),
                      'linkedin' => _s_get_acf_option( 'linkedin' ),
                      'youtube' => _s_get_acf_option( 'youtube' ),
                 );
                 
                                
                $profiles = _s_get_social_icons( $social_profiles );
                
                if( !empty( $profiles ) ) {
                    printf( '<div class="widget widget-two"><h3>Stay Connected!</h3>%s</div>', $profiles );
                }
             }
             // Signup Form
             
            ?>
            </div>
            
            <div class="small-12 large-4 columns">
            <?php
            $content = get_field( 'footer_widget_three', 'options' );
            
            $button  = get_field( 'footer_widget_three_button', 'options' );
            if( ! empty( $button ) ) {
                $button = sprintf( '<p>%s</p>', pb_get_cta_button( $button['button'], array( 'class' => 'button green' ) ) ); 
            }
            printf( '<div class="widget widget-three">%s%s</div>', $content, $button );
            ?>
            </div>
        
        </div>
    </div>

</div>

<footer id="colophon" class="site-footer" role="contentinfo">
     <div class="wrap">
        
        <div class="row align-center">
                <div class="small-12 large-4 columns text-center">
                
                <?php
                
                print( '<p>' );
                
                printf( '<span>&copy; %s Boys & Girls Clubs of King County. All rights reserved.</span>', date( 'Y' ) );
                
                if( has_nav_menu( 'footer' ) ) {
                    $args = array( 
                    'theme_location'  => 'footer', 
                     'container'       => false,
                     'echo'            => false,
                     'items_wrap'      => '%3$s',
                     'link_before'     => '<span>',
                     'link_after'      => '</span>',
                     'depth'           => 0,
                    ); 
                
                    printf( '<span>%s</span>', str_replace('<a', '<b> | </b><a', strip_tags( wp_nav_menu( $args ), '<a>' ) ) );
                 
                }
                               
                print( '<span>BGCKC is a 501(c)3 (nonprofit) organization and donations are tax deductible.</span>' );
                
                //printf( '<span><a href="%1$s">Seattle Web Design</a> by <a href="%1$s" target="_blank">Sayenko Design</a>.</span>','https://www.sayenkodesign.com' );
                
                print( '</p>' );
                ?>
				</div>
		</div>
	</div>
    
 </footer><!-- #colophon -->

<?php 
 
wp_footer(); 
?>
</body>
</html>
