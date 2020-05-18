<?php
/*
	var: 	
		$items_on_row
		$item_count
*/
	$has_right_padding = (0 == $item_count % $items_on_row) ? '' : ' has_right_padding';
	$bg_img_url = "";
	if (has_post_thumbnail()) {
		$bg_img_url = get_the_post_thumbnail_url('', 'full');
	}

	$custom_css_class = ' albums_' . $items_on_row . "_on_row";

?>

<div class="single_album_item single_artist_item <?php echo esc_attr($has_right_padding).esc_attr($custom_css_class); ?>">
	<a href="<?php the_permalink();?>">
		<div class="artist_img_container lc_swp_background_image" data-bgimage="<?php echo esc_url($bg_img_url); ?>">
		</div>
		<div class="album_overlay transition3"></div>
		<h3 class="artist_title album_heading transition4"> <?php the_title(); ?> </h3>
	</a>
</div>