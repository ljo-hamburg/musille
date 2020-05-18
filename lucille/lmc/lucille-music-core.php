<?php

require_once( get_template_directory()."/lmc/custom_meta_boxes.php");


/* 
|--------------------------------------------------------------------------
| LOAD SCRIPTS AND STYLES
|--------------------------------------------------------------------------
*/
/*
	Load scripts and styles
*/
function LUCILLE_SWP_plugin_load_scripts_and_styles() {
	/*generic admin css*/
	wp_register_style( 'js_backend_css', plugins_url('/css/backend_style.css', __FILE__));
	wp_enqueue_style( 'js_backend_css');
}
add_action( 'admin_enqueue_scripts', 'LUCILLE_SWP_plugin_load_scripts_and_styles');


/*
	Set Default Visual Composer Editor
*/
if (function_exists("vc_set_default_editor_post_types")) {
	$posts_support_vc = array( 'page' );
	vc_set_default_editor_post_types($posts_support_vc);
}

/* 
|--------------------------------------------------------------------------
| FLUSH REWRITE RULES
|--------------------------------------------------------------------------
*/
/*
	Flush rewrite rules on activation/deactivation
	Needed by the functionality that renames the slug for custom post types and taxonomies for custom post types
*/
function LUCILLE_SWP_activate() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'LUCILLE_SWP_activate');

function LUCILLE_SWP_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'LUCILLE_SWP_deactivate');

?>