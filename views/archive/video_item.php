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

?>

<div class="single_video_item<?php echo esc_attr($has_right_padding); ?>">
	<a href="<?php the_permalink();?>">
		<div class="video_image_container lc_swp_background_image" data-bgimage="<?php echo esc_url($bg_img_url); ?>">
			<i class="fa fa-play-circle lc_icon_play_video" aria-hidden="true"></i>
		</div>
	</a>

	<a href="<?php the_permalink(); ?>">
		<h3 class="video_title transition3"> <?php the_title(); ?> </h3>
	</a>
</div>
