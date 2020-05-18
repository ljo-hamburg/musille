<?php
	wp_reset_postdata();
	
	$post_id = LUCILLE_SWP_get_current_page_id();
	$post_bg_image = LUCILLE_SWP_get_post_bg_image($post_id);
	$post_overlay_color = LUCILLE_SWP_get_post_overlay_color($post_id);
	$image_source = '';
	
	if (!empty($post_bg_image)) {
		$image_source = $post_bg_image;
	} else {
		$image_source = LUCILLE_SWP_get_inner_bg_image();
	}

	if (!empty($image_source)) {
	?>
		<div class="canvas_image lc_swp_background_image" data-bgimage="<?php echo esc_url($image_source); ?>"></div>
	<?php
	}

	if (!empty($post_overlay_color)) {
	?>
		<div class="canvas_overlay lc_swp_bg_color" data-color="<?php echo esc_attr($post_overlay_color); ?>"></div>
	<?php
	}

?>