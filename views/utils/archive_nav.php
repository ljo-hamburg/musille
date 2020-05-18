<?php
	/*
		query var:
			$class_archive_nav
	*/

	$older_post_str = esc_html__('  Older posts', 'lucille');
	$newer_post_str = esc_html__('Newer posts  ', 'lucille');
	
	if (strpos($class_archive_nav, "discography_post_nav")) {
		$older_post_str = esc_html__('  Older music', 'lucille');
		$newer_post_str = esc_html__('Newer music  ', 'lucille');
	}
	if (strpos($class_archive_nav, "video_post_nav")) {
		$older_post_str = esc_html__('  Older videos', 'lucille');
		$newer_post_str = esc_html__('Newer videos  ', 'lucille');
	}	
	//
?>

<div class="<?php echo esc_attr($class_archive_nav); ?> clearfix page_navigation">
	<div class="archive_nav text_left older_post_link">
		<?php next_posts_link('<i class="fa fa-long-arrow-left" aria-hidden="true"></i>' . $older_post_str); ?>
	</div>

	<div class="archive_nav text_right newer_post_link">
		<?php previous_posts_link($newer_post_str . '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>'); ?>
	</div>
</div>