<?php

/*
	UTILITIES FUNCTIONS
*/
function LUCILLE_SWP_getIDFromShortURL($short_url) 
{
	@$elements = explode("/", $short_url);
	@$dim = count($elements); 
	
	if ($dim == 0) {
		return "";
	} else {
		return $elements[ $dim - 1];
	}
}

function LUCILLE_SWP_emphasize_title_for_this_page() {
	$templates_to_match = array(
		'template-blog.php',
	);

	if (is_page_template($templates_to_match)) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_get_translated_month($english_month_name) {

	switch (strtolower($english_month_name)) {
	    case "january":
			return esc_html__("january", "lucille");
	    case "february":
			return esc_html__("february", "lucille");
	    case "march":
			return esc_html__("march", "lucille");
	    case "april":
			return esc_html__("april", "lucille");
	    case "may":
			return esc_html__("may", "lucille");
	    case "june":
			return esc_html__("june", "lucille");
	    case "july":
			return esc_html__("july", "lucille");
	    case "august":
			return esc_html__("august", "lucille");
	    case "september":
			return esc_html__("september", "lucille");
	    case "october":
			return esc_html__("october", "lucille");
	    case "november":
			return esc_html__("november", "lucille");
	    case "december":
			return esc_html__("december", "lucille");
	}

	return $english_month_name;
}

function LUCILLE_SWP_is_sharing_visible() {
	/*always disable sharing for some pages*/
	if (function_exists("is_checkout")) {
		if (is_checkout() || is_cart()) {
			return false;
		}
	}

	return LUCILLE_SWP_show_sharing_icons_by_setting();
}

function LUCILLE_SWP_is_woocommerce_active()
{
	if (class_exists('woocommerce')) {
		return true;
	}

	return false;
}

function LUCILLE_SWP_is_woocommerce_special_page() {
	if (function_exists("is_shop")) {
		if (is_shop()) {
			return true;
		}
	}
	if (function_exists("is_product")) {
		if (is_product()) {
			return true;
		}
	}
	if (function_exists("is_cart")) {
		if (is_cart()) {
			return true;
		}
	}

	return false;
}

function LUCILLE_SWP_get_current_page_id() {
	if (LUCILLE_SWP_is_woocommerce_active()) {
		if (is_shop()) {
			return wc_get_page_id('shop');
		}
		if (is_account_page()) {
			return wc_get_page_id('myaccount');
		}
		if (is_checkout()) {
			return wc_get_page_id('checkout');	
		}
	}

	if (!in_the_loop()) {
    	/** @var $wp_query wp_query */
	    global $wp_query;
		return  $wp_query->get_queried_object_id();
	}

	return get_the_ID();
}

function LUCILLE_SWP_get_page_custom_menu_style(&$page_logo, &$menu_bar_bg, &$menu_txt_col) {
	$post_id 		= LUCILLE_SWP_get_current_page_id();
	$page_logo = $menu_bar_bg = $menu_txt_col = $above_menu_bg = $above_menu_txt_col = "";

	$page_logo 	= get_post_meta($post_id, 'lc_swp_meta_page_logo', true);
	$menu_bar_bg = get_post_meta($post_id, 'lc_swp_meta_page_menu_bg', true);
	$menu_txt_col = get_post_meta($post_id, 'lc_swp_meta_page_menu_txt_color', true);

	return (!empty($menu_bar_bg) ||
		!empty($menu_txt_col));
}

function LUCILLE_SWP_is_product_archive() {
	if (!LUCILLE_SWP_is_woocommerce_active()) {
		return false;
	}

	if (is_shop()) {
		return true;
	}

	return false;
}

?>
