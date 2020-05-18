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
	$album_artist = get_post_meta(get_the_ID(), 'album_artist', true);
	$custom_css_class = ' albums_' . $items_on_row . "_on_row";

?>

<div class="single_album_item<?php echo esc_attr($has_right_padding).esc_attr($custom_css_class); ?>">
	<a href="<?php the_permalink();?>">
		<div class="album_image_container lc_swp_background_image" data-bgimage="<?php echo esc_url($bg_img_url); ?>">
		</div>
		<div class="album_overlay transition3"></div>
		<h3 class="album_title album_heading transition4"> <?php the_title(); ?> </h3>
		<h3 class="album_artist album_heading transition4"> <?php echo esc_html($album_artist); ?> </h3>
	</a>
</div>