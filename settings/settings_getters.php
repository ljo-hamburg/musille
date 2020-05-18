<?php

function LUCILLE_SWP_get_inner_bg_image() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_innner_bg_image');
}

function LUCILLE_SWP_get_user_logo_img() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_logo');
}

function LUCILLE_SWP_get_user_favicon() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_favicon');
}

function LUCILLE_SWP_get_menu_style() {
	$menu_style = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_style');

	/*cannot return empty value*/
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	return $menu_style;
}

function LUCILLE_SWP_get_close_creative_option() {
	$close_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_creative_close');

	/*cannot return empty value*/
	if (empty($close_menu)) {
		$close_menu = 'disabled';
	}

	return $close_menu;
}

function LUCILLE_SWP_get_header_footer_width() {
	$header_width = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_header_footer_width');

	/*cannot return empty value*/
	if (empty($header_width)) {
		$header_width = 'full';
	}

	return $header_width;
}

function LUCILLE_SWP_get_default_color_scheme() {
	$color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_default_color_scheme');
	if (!empty($color_scheme)) {
		return $color_scheme;
	}

	return  'white_on_black';
}

function LUCILLE_SWP_is_sticky_menu() {
	$sticky_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu) || ("enabled" == $sticky_menu)) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_is_back_to_top_enabled() {
	$back_to_top = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_back_to_top');

	if (empty($back_to_top) || ("disabled" == $back_to_top)) {
		return false;
	}

	return true;
}

function LUCILLE_SWP_show_search_on_menu() {
	$hide_icon = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_search_icon');

	if (empty($hide_icon)) {
		return true;
	}

	return "enabled" == $hide_icon ? false : true;
}

function LUCILLE_SWP_show_event_title() {
	$show_event_title = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_title_event_list');

	if (empty($show_event_title)) {
		return false;
	}

	return "enabled" == $show_event_title ? true : false;
}

function LUCILLE_SWP_show_sharing_icons_by_setting() {
	$hide_sharing_icons = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_sharing_icons');

	if (empty($hide_sharing_icons)) {
		return true;
	}

	return "enabled" == $hide_sharing_icons ? false : true;
}

function LUCILLE_SWP_auto_show_featured_image() {
	$auto_featured_image = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_auto_featured_image');

	if (empty($auto_featured_image)) {
		return true;
	}

	return "enabled" == $auto_featured_image ? true : false;
}

function LUCILLE_SWP_single_has_sidebar() {
	$remove_singlepost_sidebar = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_singlepost_sidebar');

	if (empty($remove_singlepost_sidebar)) {
		return true;
	}

	return "enabled" == $remove_singlepost_sidebar ? false : true;
}

function LUCILLE_SWP_keep_blog_meta() {
	$remove_blog_post_meta = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_blog_post_meta');

	if (empty($remove_blog_post_meta)) {
		return true;
	}

	return "enabled" == $remove_blog_post_meta ? false : true;
}

function LUCILLE_SWP_keep_single_post_meta() {
	$remove_single_blog_post_meta = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_single_blog_post_meta');

	if (empty($remove_single_blog_post_meta)) {
		return true;
	}

	return "enabled" == $remove_single_blog_post_meta ? false : true;
}

function LUCILLE_SWP_woo_has_sidebar() {
	$shop_has_sidebar = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_shop_has_sidebar');

	if (empty($shop_has_sidebar)) {
		return false;
	}

	return "enabled" == $shop_has_sidebar ? true : false;
}

function LUCILLE_SWP_has_cpt_comments() {
	$enable_cpt_comments = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_enable_cpt_comments');

	if (empty($enable_cpt_comments)) {
		return false;
	}

	return "enabled" == $enable_cpt_comments ? true : false;
}

function LUCILLE_SWP_show_img_caption() {
	$show_img_caption = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_img_caption');

	if (empty($show_img_caption)) {
		return false;
	}

	return "enabled" == $show_img_caption ? true : false;
}

function LUCILLE_SWP_show_ctp_tax_on_archive() {
	$show_cpt_tax = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_cpt_tax');

	if (empty($show_cpt_tax)) {
		return false;
	}

	return "enabled" == $show_cpt_tax ? true : false;
}

function LUCILLE_SWP_show_album_date_as_year() {
	$show_album_date = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_album_date');

	if (empty($show_album_date)) {
		return false;
	}

	return "year" == $show_album_date ? true : false;
}


function LUCILLE_SWP_show_download_button() {
	$show_download_button = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'swp_show_download_button');

	if (empty($show_download_button)) {
		return false;
	}

	return "enabled" == $show_download_button ? true : false;	
}

function LUCILLE_SWP_need_woo_sidebar_on_this_page() {
	if (!LUCILLE_SWP_is_woocommerce_active()) {
		return false;
	}

	if (!LUCILLE_SWP_woo_has_sidebar()) {
		return false;
	}

	if (is_shop() || 
		is_product_category() || 
		is_product_tag() || 
		is_product()) {
		return LUCILLE_SWP_woo_has_sidebar();
	}

	return false;
}

function LUCILLE_SWP_get_available_social_profiles() {
	$user_profiles = array();

	$available_profiles = array(
		/*'icon name fa-[icon name]'	=> 'settings name'*/
		'facebook'			=> 'lc_fb_url',
		'twitter'			=>'lc_twitter_url',		
		'instagram'			=> 'lc_instagram_url',		
		'snapchat-ghost'	=> 'lc_snapchat_url',		
		'pinterest'			=>'lc_pinterest_url',		
		'youtube'			=>'lc_youtube_url',	
		'vimeo'				=> 'lc_vimeo_url',		
		'soundcloud'		=>'lc_soundcloud_url',	
		'play'				=> 'lc_gplay_url',		
		'amazon'			=>'lc_amazon_music_url',
		'apple'				=>'lc_itunes_url',
		'spotify'			=> 'lc_spotify_url',
		'linkedin'			=> 'lc_linkedin_url',
		'imdb'				=> 'lc_imdb_url',
		'vk'				=> 'lc_vk_url',
		'bandcamp'			=> 'lc_bandcamp_url'
	);

	foreach ($available_profiles as $key =>	$profile) {
		$profile_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', $profile);

		if (!empty($profile_url)) {
			$single_profile = array();
			$single_profile['url'] 	= $profile_url;
			$single_profile['icon'] 	= $key;

			$user_profiles[] = $single_profile;
		}
	}

	return $user_profiles;
}

/*getters for footer options*/
function LUCILLE_SWP_get_footer_color_scheme() {
	$footer_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_color_scheme');
	
	if (!empty($footer_color_scheme)) {
		return $footer_color_scheme;
	}

	return 'white_on_black';
}

function LUCILLE_SWP_get_footer_bg_image() {
	return LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_image');
}

function LUCILLE_SWP_get_footer_bg_color() {
	$footer_background_color = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_color');
	
	if (!empty($footer_background_color)) {
		return $footer_background_color;
	}

	return 'rgba(19, 19, 19, 1)';
}

function LUCILLE_SWP_get_copyrigth_text() {
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text'));
}

function LUCILLE_SWP_get_copyrigth_url() {
	return esc_url_raw(LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_url'));
}

function LUCILLE_SWP_get_copyright_bgc() {
	$copy_bgc = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_bg_color');
	if (!empty($copy_bgc)) {
		return $copy_bgc;
	}

	return 'rgba(29, 29, 29, 1)';
}

function LUCILLE_SWP_get_copyrigth_color_scheme() {
	$copy_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_color');
	if (!empty($copy_color_scheme)) {
		return $copy_color_scheme;
	}

	return 'white_on_black';
}

function LUCILLE_SWP_get_post_bg_image($post_id) {
	return get_post_meta($post_id, 'js_swp_meta_bg_image', true);
}

function LUCILLE_SWP_get_post_overlay_color($post_id) {
	return get_post_meta($post_id, 'lc_swp_meta_page_overlay_color', true);
}

function LUCILLE_SWP_get_contact_address() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_address'));
}

function LUCILLE_SWP_get_contact_email() 
{
	return sanitize_email(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_email'));
}

function LUCILLE_SWP_get_contact_phone() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_phone'));
}

function LUCILLE_SWP_get_2nd_contact_phone() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_phone2'));
}

function LUCILLE_SWP_get_contact_fax() 
{
	return esc_html(LUCILLE_SWP_get_theme_option('lucille_theme_contact_options', 'lc_contact_fax'));
}

function LUCILLE_SWP_use_default_fonts() {
	$fonts_custom_default = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_fonts_custom_default');
	if (empty($fonts_custom_default)) {
		return true;
	}

	if ("use_defaults" == $fonts_custom_default) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_get_user_primary_font() {
	$primary_font = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_primary_font');
	if (empty($primary_font)) {
		return 'Open Sans';
	}

	return $primary_font;
}

function LUCILLE_SWP_get_user_secondary_font() {
	$secondary_font = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_secondary_font');
	if (empty($secondary_font)) {
		return 'Oswald';
	}

	return $secondary_font;
}

function LUCILLE_SWP_generate_fonts_family($primary, $secondary) {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$final_fonts = '';
	$found_fonts = 0;
	foreach($fonts_json as $font_json) {
		if (($primary == $font_json['family']) || 
			($secondary == $font_json['family'])) {

			$found_fonts++;
			if (strlen($final_fonts)) {
				$final_fonts .= '|';
			}
			$final_fonts .= str_replace(' ', '+', $font_json['family']) . ':' . $font_json['variants'];

			/*get out of the loop after two fonts found*/
			if (2 == $found_fonts) {
				break;
			}
		}/*if*/
	}/*foreach*/

	return $final_fonts . '&subset=latin,latin-ext';
}

if ( !function_exists('LUCILLE_SWP_get_fonts_family_from_settings') ) {
	function LUCILLE_SWP_get_fonts_family_from_settings() {
		if (LUCILLE_SWP_use_default_fonts()) {
			return 'Open+Sans:400,600,700,800|Oswald:300,400,700&subset=latin,latin-ext';
		}

		$primary_font = LUCILLE_SWP_get_user_primary_font();
		$secondary_font = LUCILLE_SWP_get_user_secondary_font();

		return LUCILLE_SWP_generate_fonts_family($primary_font, $secondary_font);
	}
}

?>