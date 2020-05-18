<?php
	
	$post_id 		= LUCILLE_SWP_get_current_page_id();

	$title			= get_the_title();
	$subtitle 		= esc_html(get_post_meta($post_id, 'lc_swp_meta_subtitle', true));
	$color_theme 	= get_post_meta($post_id, 'lc_swp_meta_heading_color_theme', true);
	$heading_style 	= get_post_meta($post_id, 'lc_swp_meta_heading_full_color', true); /*title_full_color, title_transparent_color*/
	$bg_image 		= get_post_meta($post_id, 'lc_swp_meta_heading_bg_image', true);
	$overlay 		= get_post_meta($post_id, 'lc_swp_meta_heading_overlay_color', true);

	if (is_author() || 
		is_category() || 
		(is_archive() && !LUCILLE_SWP_is_product_archive()) || 
		is_home() || 
		is_search()) {
		$subtitle = $bg_image = $overlay = "";
		$color_theme = LUCILLE_SWP_get_default_color_scheme();
	}
	if (is_404()) {
		$subtitle = esc_html__("404 - Page not found", "lucille");
		$title = esc_html__("OOPS!", "lucille");
		/*$color_theme = LUCILLE_SWP_get_default_color_scheme();*/
		/*since the background header image is always the same, the color scheme should be white on black*/
		$color_theme = " white_on_black";
		$heading_style = 'title_transparent_color';
		$bg_image = get_template_directory_uri().'/core/img/404NotFound.jpg';
		$overlay = 'rgba(0,0,0, 0.8)';
	}
	if (LUCILLE_SWP_is_woocommerce_special_page()) {
		$color_theme = LUCILLE_SWP_get_default_color_scheme();
	}
	/*for product category, use the category image as header image*/
	if (function_exists("is_product_category")) {
		if (is_product_category()) {
			global $wp_query;
			$cat = $wp_query->get_queried_object();
	 		$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
	 		$image = wp_get_attachment_url($thumbnail_id);
	 		/*disable this feature - should be implemented as a new option in product category (heading image)*/
	 		// if ($image) {
				// $bg_image = $image;
	 		// }
 		}
	}

	/*
		Add css classes
	*/
	$heading_area_classes = '';
	$data_bgimage = '';
	$img_overlay_div = '';

	if (!empty($bg_image)) {
		$data_bgimage = ' data-bgimage="'.esc_url($bg_image).'"';
		$img_overlay_div = '<div class="lc_swp_background_image lc_heading_image_bg"'.$data_bgimage.'></div>';
	}

	/*Supported color themes: white_on_black, black_on_white */
	$heading_area_classes .= ' '.esc_attr($color_theme);
	if (empty($subtitle)) {
		$heading_area_classes .= ' no_subtitle';
	} else {
		$heading_area_classes .= ' have_subtitle';
	}

	/*handle overlay*/
	$overlay_div = '';
	if (!empty($overlay)) {
		$overlay_div = '<div class="lc_swp_overlay" data-color="'.esc_attr($overlay).'"></div>';
	}

	/*handle subtitle*/
	$subtitle_div = '';
	if (!empty($subtitle)) {
		$subtitle_div = '<h2 class="heading_area_subtitle>">'.esc_html($subtitle).'</h2>';
	}

	/*add vibrant color for h2 only on full color h1 (first layout option)*/
	$colorItVibrant = '';
	if ('title_full_color' == $heading_style) {
		$colorItVibrant = ' lc_vibrant_color';
	}

	$additional_title_class = '';
	if (empty($subtitle)) {
		$additional_title_class = ' no_subtitle';
	}
	/*keep header with big height for some cases*/
	if (is_tax()) {
		$additional_title_class .= ' spaced_title';
	} elseif (empty($subtitle) && LUCILLE_SWP_emphasize_title_for_this_page()) {
		$additional_title_class .= ' spaced_title';
	}

	/*title for special templates - keep this the latest processed data*/
	if (is_author()) {
		$title = esc_html__('Author: ', "lucille").get_the_author();
	} elseif (is_category()) {
		$title = single_cat_title("", FALSE);
	} elseif (is_archive()) {
		if (is_tax()) {
			/*custom taxonomy*/
			$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$title = $term->name;
		} else {
			$title = get_the_time(get_option('date_format'));	
		}
	} elseif (is_home()) {
		$title = esc_html__("Blog", "lucille");
	} elseif (is_search()) {
		$title = get_search_query();
	}

	/*treat separately the shop and product page [[[*/
	if (function_exists("is_shop")) {
		if (is_shop()) {
			$title = woocommerce_page_title(false);
		}
	}
	if (function_exists("is_product")) {
		if (is_product()) {
			$title = woocommerce_page_title(false);
		}
	}
	/*treat separately the shop and product page ]]]*/
?>


<div id="heading_area" class="<?php echo esc_attr($heading_area_classes); ?>">
	<?php
		/*image overlay*/
		$allowed_html = array(
			'div'	=> array(
				'id'			=> array(),
				'class'			=> array(),
				'data-bgimage'	=> array(),
				'data-color'	=> array()
			)
		);
		echo wp_kses($img_overlay_div, $allowed_html);
	?>

	<?php
		/*color overlay*/
		echo wp_kses($overlay_div, $allowed_html);
	?>
	
	<div class="heading_content_container lc_swp_boxed<?php echo esc_attr($additional_title_class); ?>">
		<div class="heading_titles_container">
			<div class="heading_area_title <?php echo esc_attr($heading_style); echo esc_attr($additional_title_class); ?>">
				<h1 class="<?php echo esc_attr($heading_style); ?>"> <?php echo esc_html($title); ?> </h1>
			</div>	
			
			<?php 
			if (!empty($subtitle)) {
			?>
				<div class="heading_area_subtitle <?php echo esc_attr($heading_style); ?>">
					<h2 class="<?php echo esc_attr($heading_style.$colorItVibrant); ?>"><?php echo esc_html($subtitle); ?></h2>
				</div>
			<?php
			}
			?>
		</div>
		<?php get_template_part('views/utils/post_meta'); ?>
	</div>

	<?php get_template_part('views/utils/cpt_post_meta'); ?>
	
	<?php
	if (LUCILLE_SWP_show_ctp_tax_on_archive()) { 
		get_template_part('views/utils/cpt_archive_meta');
	}
	?>
	
</div>