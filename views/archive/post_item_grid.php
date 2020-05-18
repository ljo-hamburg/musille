<?php 
	$post_classes = 'post_item lc_blog_masonry_brick';
	$item_details_thumb_class = '';
	if (has_post_thumbnail()) {
		$post_classes .= ' has_thumbnail';
	} else {
		$post_classes .= ' no_thumbnail';
		$item_details_thumb_class .= ' no_thumbnail';
	}

	$masonry_excerpt_length = 15;

	$taxonomy_type = 'category';
	$button_text = esc_html__("Read more", "lucille");
	$post_type = get_post_type();

	$meta_hide_class = "";
	if (!LUCILLE_SWP_keep_blog_meta()) {
		$meta_hide_class = " display_none";
	}
?>

<article <?php post_class($post_classes);?>>
	<?php if (has_post_thumbnail()) { ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('full', array('class' => 'lc_masonry_thumbnail_image')); ?>
		</a>

		<div class="brick_cover_bg_image transition4"></div>
		<div class="brick_bg_overlay"></div>
	<?php } ?>

	<div class="post_item_details<?php echo esc_attr($item_details_thumb_class); ?>">
		<a href="<?php the_permalink(); ?>">
			<h2 class="lc_post_title transition4 masonry_post_title">
				<?php the_title(); ?>
			</h2>
		</a>

		<div class="post_item_meta lc_post_meta masonry_post_meta<?php echo esc_attr($meta_hide_class); ?>">
			<?php echo get_the_date(get_option('date_format')); ?>
			<?php echo esc_html__('by', 'lucille'); ?>
			<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
				<?php the_author(); ?>
			</a>
			<?php


			if (has_term('', $taxonomy_type)) {
				echo esc_html__('in&nbsp;', 'lucille');
				the_terms('', $taxonomy_type, '', ' &#8901; ', '');
			}
			?>
		</div>


		<div class="lc_post_excerpt">
			<?php
				$default_excerpt = get_the_excerpt();
				echo "<p>".wp_trim_words($default_excerpt, $masonry_excerpt_length)."</p>";
			?>
		</div>

		<div class="lc_button">
			<a href="<?php the_permalink(); ?>">
				<?php echo esc_html($button_text); ?>
			</a>
		</div>
	</div>
</article>