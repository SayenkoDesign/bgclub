<?php

/****************************************
	WordPress Cleanup functions - work in progress
*****************************************/
	include_once( 'wp-cleanup.php' );


/****************************************
	Theme Settings - load main stylesheet, add body classes
*****************************************/
	include_once( 'theme-settings.php' );



/****************************************
	include_onces (libraries, Classes etc)
*****************************************/
	include_once( 'includes/cpt-core/CPT_Core.php' );

	include_once( 'includes/taxonomy-core/Taxonomy_Core.php' );
    
    include_once( 'includes/table-class.php' );

    include_once( 'includes/theme-functions/array.php' );

/****************************************
	Functions
*****************************************/

    include_once( 'functions/svg.php' );

	include_once( 'functions/theme.php' );

	include_once( 'functions/template-tags.php' );

	include_once( 'functions/acf.php' );

	include_once( 'functions/fonts.php' );

	include_once( 'functions/scripts.php' );

	include_once( 'functions/social.php' );

	include_once( 'functions/menus.php' );
    
    //include_once( 'functions/videos.php' );
    
    include_once( 'functions/blog.php' );
    
    include_once( 'functions/mega-menu.php' );

	//include_once( 'functions/gravity-forms.php' );

	include_once( 'functions/widgets.php' );

    include_once( 'functions/addtoany.php' );

/****************************************
	include_onces (Foundation)
*****************************************/

include_once( 'foundation/class-foundation.php' );
include_once( 'foundation/class-foundation-accordion.php' );
include_once( 'foundation/class-foundation-tabs.php' );
include_once( 'foundation/class-foundation-grid.php' );

/****************************************
	Page Builder
*****************************************/


 	include_once( 'page-builder/functions.php' );

	include_once( 'page-builder/markup.php' );

	include_once( 'page-builder/layout.php' );

	include_once( 'page-builder/filters.php' );

	// Load modules
    include_once( 'page-builder/modules/button.php' );
	//include_once( 'page-builder/modules/content-block.php' );
    //include_once( 'page-builder/modules/list.php' );
	//include_once( 'page-builder/modules/grid.php' );

/****************************************
	Post Types
*****************************************/
    
    include_once( 'post-types/cpt-club.php' );
    include_once( 'post-types/cpt-event.php' );
	include_once( 'post-types/cpt-program.php' );
    include_once( 'post-types/cpt-footer_cta.php' );