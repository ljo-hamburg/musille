<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php get_template_part('views/single/default_single'); ?>
	<?php endwhile; else : ?>
		<div class="lc_content_full lc_swp_boxed">
			<p><?php esc_html__('Sorry, no posts matched your criteria.', 'lucille'); ?></p>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>