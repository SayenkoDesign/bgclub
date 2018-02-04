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
            printf( '<div class="widget widget-one">%s</div>',  get_svg( 'logo-footer' ) );
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
                $button = sprintf( '<p>%s</p>', pb_get_cta_button( $button['button'], array( 'class' => 'button secondary' ) ) ); 
            }
            printf( '<div class="widget widget-three">%s%s</div>', $content, $button );
            ?>
            </div>
        
        </div>
    </div>

</div>

<footer id="colophon" class="site-footer" role="contentinfo">
     <div class="wrap">
        
        <div class="row">
                <div class="small-12 large-4 large-centered columns text-center">
                <?php
                printf( '<p><span>&copy; %s Boys & Girls Club of King County. All rights reserved.</span><span><a href="%2$s">Seattle Web Design</a> by <a href="%2$s" target="_blank">Sayenko Design</a>.</span><span>BGCA is a 501(c)3 (nonprofit) organization and donations are tax deductible.</span></p>', 
                date( 'Y' ), 'https://www.sayenkodesign.com' );
                
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
