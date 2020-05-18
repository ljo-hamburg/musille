<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php the_content(); ?>
		<?php get_template_part('views/utils/sharing_icons'); ?>
		<?php comments_template(); ?>
	<?php endwhile; else : ?>
		<p><?php esc_html__('Sorry, no posts matched your criteria.', 'lucille'); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>