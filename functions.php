<?php

require_once(get_template_directory()."/lmc/lucille-music-core.php");

/*
	Load theme textdomain, editor style, auto feed links, custom background support
	Load the main stylesheet - style.css
	Load Needed Google Fonts
	Set excerpt length and Remove [...] string from excerpt
	Set the content width
*/
require_once(get_template_directory()."/core/basic_theme_setup.php");

/*
	Theme Settings Menu
*/
require_once(get_template_directory()."/settings/theme_settings.php");
require_once(get_template_directory()."/settings/settings_getters.php");

/*
	Set as theme Visual Composer
*/
if (function_exists("vc_set_as_theme")) {
	add_action( 'vc_before_init', 'LUCILLE_SWP_vcSetAsTheme' );
	function LUCILLE_SWP_vcSetAsTheme() {
		vc_set_as_theme(true);	
	}
}

/*
	Set as theme Slider Revolution
*/
if (function_exists('set_revslider_as_theme')) {
	add_action( 'init', 'LUCILLE_SWP_RevSliderSetAsTheme' );
	function LUCILLE_SWP_RevSliderSetAsTheme() {
		set_revslider_as_theme();
	}
}

/*
	Theme Customizer
*/
require_once(get_template_directory()."/customizer/theme_customizer.php");

/* Setup the Theme Customizer settings and controls*/
add_action('customize_register', array('LUCILLE_SWP_Customize' , 'register'));

/* Output custom CSS to live site*/
add_action('wp_head', array('LUCILLE_SWP_Customize' , 'header_output'));

/* Enqueue live preview javascript in Theme Customizer admin screen*/
add_action('customize_preview_init' , array('LUCILLE_SWP_Customize', 'live_preview'));


/*
	Load needed js scripts and css styles
	Calls of wp_enqueue_script and wp_enqueue_style
*/
require_once(get_template_directory()."/core/enqueue_scripts.php");


/*
	Register theme sidebars
*/
require_once(get_template_directory()."/core/register_theme_sidebars.php");


/*
	Utilities
*/
require_once(get_template_directory()."/core/utils.php");

/*
	Custom Post States
*/
require_once(get_template_directory()."/core/post_states.php");

?>