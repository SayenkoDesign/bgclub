<?php

/*
Hero
		
*/

section_hero();
function section_hero() {
	global $post;
    
    $background_image = get_the_post_thumbnail_url( get_the_ID(), 'hero' );
    
    $post_categories =  get_the_category_list( '' );
    
    $heading = sprintf( '<h1>%s</h1>', get_the_title() );
    $description = sprintf( '<p>%s</p>', _s_get_posted_on() );
    
 	
	$style = '';
  	$content = '';
	
	if( !empty( $background_image ) ) {
		$style = sprintf( 'background-image: url(%s);', $background_image );
	}
	
	
	$args = array(
		'html5'   => '<section %s>',
		'context' => 'section',
		'attr' => array( 'id' => 'hero', 'class' => 'section hero flex', 'style' => $style ),
		'echo' => false
	);
	
	$out = _s_markup( $args );
	$out .= _s_structural_wrap( 'open', false );
	
	
	$out .= sprintf( '<div class="row"><div class="small-12 columns">%s%s%s</div></div>', $description, $heading, $post_categories );
	
	$out .= _s_structural_wrap( 'close', false );
	$out .= '</section>';
	
	echo $out;
    
    printf( '<div class="wave-bottom">%s</div>', get_svg( 'wave-bottom' ) );
		
}