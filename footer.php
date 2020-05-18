	<?php  if (LUCILLE_SWP_need_woo_sidebar_on_this_page()) { /*close same condition linked container from header.php*/ ?>
		</div>
	<?php } ?>

	</div> <!--#lc_swp_content-->
	<?php get_sidebar('footer'); ?>
	<?php get_template_part('views/canvas_image'); ?>
	<?php get_template_part('views/utils/back_to_top'); ?>
	<?php get_template_part('views/utils/search_form_global'); ?>
	</div> <!--#lc_swp_wrapper-->
	<?php wp_footer(); ?>
</body>
</html> 