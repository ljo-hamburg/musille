<?php 

if (!function_exists('LUCILLE_SWP_setup')) {
	function LUCILLE_SWP_setup() {
		//theme textdomain for translation/localization support - load_theme_textdomain($domain, $path)
		$domain = 'lucille';
		// wp-content/languages/themes/lucille-de_DE.mo
		if (!load_theme_textdomain($domain, trailingslashit(WP_LANG_DIR).$domain)) {
			// wp-content/themes/lucille/languages
			load_theme_textdomain('lucille', get_template_directory().'/languages');
		}

		// enables post RSS feed links to head
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
	 
		// enable support for Post Thumbnails, 
		add_theme_support('post-thumbnails');

		/*support .alignwide and .alignfull Gutenberg classes*/
		add_theme_support(
		    'gutenberg',
		    array('wide-images' => true)
		);		
		
		// register Menu
		register_nav_menus(
			array(
			  'main-menu' => esc_html__('Main Menu', 'lucille'),
			)
		);
		
		// custom background support
        $defaults = array(
            'default-color'          => '151515',
            'default-image'          => '',
            'wp-head-callback'       => 'LUCILLE_SWP_custom_background_cb',
            'admin-head-callback'    => '',
            'admin-preview-callback' => ''
        );

        add_theme_support('custom-background',  $defaults);

	}
}
add_action('after_setup_theme', 'LUCILLE_SWP_setup');


function LUCILLE_SWP_custom_background_cb() {
        $color = get_background_color();
      
        if ($color) { ?>
            <style type="text/css">
                body { <?php echo trim($color ? "background-color: #$color;" : ''); ?> }
            </style>
        <?php }
}

/*
	Load the main stylesheet - style.css
*/
if (!function_exists('LUCILLE_SWP_load_main_stylesheet')) {
	function LUCILLE_SWP_load_main_stylesheet() {
		wp_enqueue_style('style', get_stylesheet_uri());
	}
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_load_main_stylesheet');

/*
	Load the font related css
*/
if (!function_exists('LUCILLE_SWP_load_fonts_css')) {
	function LUCILLE_SWP_load_fonts_css() {

		wp_enqueue_style('default_fonts', get_template_directory_uri() . "/core/css/fonts/default_fonts.css");	

		if (!LUCILLE_SWP_use_default_fonts()) {
			$primary_font = LUCILLE_SWP_get_user_primary_font();
			$secondary_font = LUCILLE_SWP_get_user_secondary_font();

			$user_fonts_css = '
				body, #heading_area.have_subtitle h1.title_full_color, #heading_area h1.title_transparent_color, 
				h3#comments-title,
				.woocommerce ul.products li.product h3,
				h2.section_title, h5.lc_reviewer_name, textarea {
					font-family: ' . $primary_font . ', sans-serif;
				}

				#logo, #mobile_logo, #heading_area h1, .heading_area_subtitle.title_full_color h2,
				input[type="submit"],
				.heading_area_subtitle.title_transparent_color h2,
				h3.footer-widget-title, h3.widgettitle,
				.lc_share_item_text, .lb-number, .lc_button, .woocommerce a.button, input.button, .woocommerce input.button, button.single_add_to_cart_button, h2.lc_post_title,
				.page_navigation,
				.eventlist_month, .emphasize_first .event_location, .emphasize_first .event_venue, .emphasize_first .event_buy, .lc_view_more, 
				h1, h2, h3, h4, h5, h6,  .wave_song_action, .artist_nickname, .swp_lightbox_downbutton {
					font-family: ' . $secondary_font . ', sans-serif;
				}
			';

			wp_add_inline_style('default_fonts', $user_fonts_css);
		} 
	}
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_load_fonts_css');

/*
	Get fonts for Gutenberg
*/
function LUCILLE_SWP_get_user_fonts_css_gutenberg($primary_font, $secondary_font) {
	$user_fonts_css = '
		.edit-post-visual-editor, .edit-post-visual-editor textarea,
		.edit-post-visual-editor h3#comments-title, .edit-post-visual-editor .woocommerce ul.products li.product h3,
		.edit-post-visual-editor h2.section_title, .edit-post-visual-editor h5.lc_reviewer_name {
			font-family: ' . $primary_font . ', sans-serif;
		}

		#heading_area h1, .heading_area_subtitle.title_full_color h2,
		.edit-post-visual-editor input[type="submit"],
		.edit-post-visual-editor .heading_area_subtitle.title_transparent_color h2,
		.edit-post-visual-editor h3.footer-widget-title, .edit-post-visual-editor h3.widgettitle,
		.edit-post-visual-editor .lc_share_item_text, .edit-post-visual-editor .lb-number,
		.edit-post-visual-editor .lc_button, .edit-post-visual-editor .woocommerce a.button,
		.edit-post-visual-editor input.button, .edit-post-visual-editor .woocommerce input.button,
		.edit-post-visual-editor button.single_add_to_cart_button,
		.edit-post-visual-editor h2.lc_post_title,
		.edit-post-visual-editor .page_navigation,
		.edit-post-visual-editor .eventlist_month, 
		.edit-post-visual-editor .emphasize_first .event_location,
		.edit-post-visual-editor .emphasize_first .event_venue, .edit-post-visual-editor .emphasize_first .event_buy,
		.edit-post-visual-editor .lc_view_more, 
		.edit-post-visual-editor h1, .edit-post-visual-editor h2, .edit-post-visual-editor h3,
		.edit-post-visual-editor h4, .edit-post-visual-editor h5, .edit-post-visual-editor h6,
		.edit-post-visual-editor .wave_song_action, .edit-post-visual-editor .artist_nickname, .edit-post-visual-editor .swp_lightbox_downbutton  {
			font-family: ' . $secondary_font . ', sans-serif;
		}
	';

	return $user_fonts_css;
}


/*
	Load Needed Google Fonts
*/
if (!function_exists('LUCILLE_SWP_load_google_fonts')) {
	function LUCILLE_SWP_load_google_fonts()
	{
		$google_fonts_family = LUCILLE_SWP_get_fonts_family_from_settings();

		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style('jamsession-opensans-oswald', $protocol."://fonts.googleapis.com/css?family=".$google_fonts_family);
	}
}
add_action('wp_enqueue_scripts', 'LUCILLE_SWP_load_google_fonts');


/*
	Control Excerpt Length
*/
if (!function_exists('LUCILLE_SWP_excerpt_length')) {
	function LUCILLE_SWP_excerpt_length($length)
	{
		return 40;
	}
}
add_filter('excerpt_length', 'LUCILLE_SWP_excerpt_length', 999);


/*
	Remove [...] string from excerpt
*/
if (! function_exists('LUCILLE_SWP_excerpt_more')) {
	function LUCILLE_SWP_excerpt_more($more) {
		return '...';
	}
}
add_filter('excerpt_more', 'LUCILLE_SWP_excerpt_more');


/*
	Implement Custom Excerpt for pages as well
*/
function LUCILLE_SWP_add_excerpt_to_pages() {
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'LUCILLE_SWP_add_excerpt_to_pages');

/*
	Make Sure Content Width is Set
*/
if (!isset($content_width)) {
	$content_width = 900;
}

/*
	Allow Shortcodes In Text Widget
*/
add_filter('widget_text', 'do_shortcode');

?>