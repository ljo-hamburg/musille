<article <?php post_class('post_item standard_blog_item');?>>
	<?php if (has_post_thumbnail()) { ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('large'); ?>
		</a>
	<?php } ?>

	<a href="<?php the_permalink(); ?>">
		<h2 class="lc_post_title transition4">
			<?php the_title(); ?>
		</h2>
	</a>

	<?php 
		$meta_hide_class = "";
		if (!LUCILLE_SWP_keep_blog_meta()) {
			$meta_hide_class = " display_none";
		}
	?>

	<div class="post_item_meta lc_post_meta<?php echo esc_attr($meta_hide_class); ?>">
		<?php echo esc_html__("Posted at&nbsp;", "lucille"); the_date(); ?>
		<?php echo esc_html__('by', 'lucille'); ?>
		<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
			<?php the_author(); ?>
		</a>
		<?php 
		echo esc_html__('in&nbsp;', 'lucille');
		the_category(' &#8901; ');
		?>
	</div>


	<div class="lc_post_excerpt">
		<?php the_excerpt(); ?>
	</div>

	<div class="lc_button">
		<a href="<?php the_permalink(); ?>">
			<?php echo esc_html__("Read more", "lucille"); ?>
		</a>
	</div>
</article>