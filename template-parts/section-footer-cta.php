<?php

/*
Section - Footer CTA
*/

 _s_footer_cta();
function _s_footer_cta() {
	        
    $footer_cta = false;
    
    if( is_single() ) {
        $footer_cta = get_field( 'choose_footer_cta' );
    }
    else {
        
        if( is_post_type_archive( 'program' ) ) {
           $field = get_field( 'program_archive_footer_cta', 'options' );
           if( isset( $field['choose_footer_cta'] ) ) {
               $footer_cta = $field['choose_footer_cta'];
           }
           
        }
        else if( is_post_type_archive( 'club' ) ) {
           $field = get_field( 'club_archive_footer_cta', 'options' );
           if( isset( $field['choose_footer_cta'] ) ) {
               $footer_cta = $field['choose_footer_cta'];
           }
        }
        else {
           $post_id = get_option('page_for_posts');         
           $footer_cta = get_field( 'choose_footer_cta', $post_id );
        }
    }
    
    // Check for Global backup
    if( empty( $footer_cta ) ) {
        $field = get_field( 'global_footer_cta', 'options' );
           if( isset( $field['choose_footer_cta'] ) ) {
               $footer_cta = $field['choose_footer_cta'];
           }
         
    }
    
    if( empty( $footer_cta ) ) {
         return;
    }
    
    $content = '';
    
    $heading        = get_field( 'cta_heading', $footer_cta );
    $description    = get_field( 'cta_description', $footer_cta );
    $buttons        = get_field( 'cta_buttons', $footer_cta );
    $buttons = $buttons['buttons'];
    
    if( !empty( $heading ) ) {
        $content .= _s_get_heading( $heading, 'h2' );
    }
    
    
    if( !empty( $description ) ) {
        $content .= $description;
     }

    if( !empty( $buttons ) ) {
        $button_group = '';
        $button_classes = array( 'button secondary', 'button secondary' );
        foreach( $buttons as $key => $button ) {
             $button_group .= pb_get_cta_button( $button['button'], array( 'class' => $button_classes[$key] ) ); 
        }
        
        $content .= sprintf( '<p class="button-group">%s</p>', $button_group );
    }
		
	$attr = array( 'id' => 'footer-cta', 'class' => 'section footer-cta' );
					
	_s_section_open( $attr );  
		printf( '<div class="column row">%s</div>', $content );
	_s_section_close();		
 }