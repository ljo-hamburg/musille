<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed">
	<div class="lc_content_with_sidebar lc_basic_content_padding">
		<?php if (have_posts()) : ?> <?php while (have_posts()) : the_post(); ?>

			<?php get_template_part('views/archive/post_item_standard');?>

		<?php endwhile; ?>

		<?php 
			$class_archive_nav = "lc_swp_full blog_standard_nav";
			set_query_var("class_archive_nav", $class_archive_nav);
			get_template_part('views/utils/archive_nav');
		?>

		<?php else :
				if (is_search()) {
					echo '<p>'.esc_html__('Sorry, no results were found matching your search criteria. Please try something else.', 'lucille').'</p>';
				} else {
					echo '<p>'.esc_html__('Sorry, no posts matched your criteria.', 'lucille').'</p>';
				}
				
		endif; ?>

	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>