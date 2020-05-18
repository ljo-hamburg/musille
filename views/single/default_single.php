<div class="lc_content_full lc_swp_boxed">
	<?php if (LUCILLE_SWP_single_has_sidebar()) {?>
	<div class="lc_content_with_sidebar lc_basic_content_padding">
	<?php } ?>
		<?php
		if (LUCILLE_SWP_auto_show_featured_image()) {
			if(has_post_thumbnail()) {
				the_post_thumbnail('full');
			}
		}
		?>

		<?php the_content(); ?>

		<?php 
		$args = array(
			'before'           => '<div class="pagination_links">' . esc_html__('Pages:', 'lucille'),
			'after'            => '</div>',
			'link_before'      => '<span class="pagination_link">',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'nextpagelink'     => esc_html__('Next page', 'lucille'),
			'previouspagelink' => esc_html__('Previous page', 'lucille'),
			'pagelink'         => '%',
			'echo'             => 1
		); 
		?>
		<?php wp_link_pages( $args ); ?>

		<?php get_template_part('views/utils/sharing_icons'); ?>
		<?php get_template_part('views/utils/post_tags'); ?>
		<?php comments_template(); ?>

	<?php if (LUCILLE_SWP_single_has_sidebar()) {?>	
	</div>
	<?php get_sidebar(); ?>
	<?php } ?>
</div>