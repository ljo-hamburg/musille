<?php 

	/*check if footer widgets are allowed from the post meta*/
	$remove_footer = "";
	if (is_author() || is_category() || is_archive() || is_home() || is_search() || is_404()) {
		/*default templates have footer by default*/
		$remove_footer = "0";
	} else {
		/*get option from page/post meta*/
		wp_reset_postdata();
		$post_id 		= get_the_ID();
		$remove_footer	= get_post_meta($post_id, 'lc_swp_meta_page_remove_footer', true);
		if (empty($remove_footer)) {
			$remove_footer = "0";
		}
	}

	if ("0" == $remove_footer) {
		$header_width = LUCILLE_SWP_get_header_footer_width();
		$header_width = 'lc_swp_'.$header_width; /*lc_swp_full/lc_swp_boxed*/

		$bg_color = LUCILLE_SWP_get_footer_bg_color();
		$bg_image = esc_url(LUCILLE_SWP_get_footer_bg_image());
		$color_scheme = LUCILLE_SWP_get_footer_color_scheme();

		if ( is_active_sidebar('footer-sidebar-1') || 
			is_active_sidebar('footer-sidebar-2') ||
			is_active_sidebar( 'footer-sidebar-3') ||
			is_active_sidebar( 'footer-sidebar-4' )) {
				?>
				<div id="footer_sidebars">
					<div id="footer_sidebars_inner" class="clearfix <?php echo esc_attr($header_width); ?>">
						<div id="footer_sidebar1" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-1')) {
						 		dynamic_sidebar('footer-sidebar-1');
						 	}
							?>
						</div>

						<div id="footer_sidebar2" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-2')) {
						 		dynamic_sidebar('footer-sidebar-2');
						 	}
							?>
						</div>

						<div id="footer_sidebar3" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-3')) {
						 		dynamic_sidebar('footer-sidebar-3');
						 	}
							?>
						</div>

						<div id="footer_sidebar4" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-4')) {
						 		dynamic_sidebar('footer-sidebar-4');
						 	}
							?>
						</div>
					</div>

					<?php
					if (!empty($bg_color)) {
					?>
						<div class="lc_swp_overlay footer_widget_overlay" data-color="<?php echo esc_attr($bg_color); ?>">
						</div>
					<?php
					}

					if (!empty($bg_image)) {
					?>
						<div class="lc_swp_image_overlay lc_swp_background_image" data-bgimage="<?php echo esc_attr($bg_image); ?>">
						</div>
					<?php
					}
					?>
				</div>

				<?php
		}
	} /*if not remove footer widgets*/

	
	$copy_bgc = LUCILLE_SWP_get_copyright_bgc();
	$copy_cs = LUCILLE_SWP_get_copyrigth_color_scheme();
	$copyrigth_text =  html_entity_decode(LUCILLE_SWP_get_copyrigth_text());
	$copyright_user_url = LUCILLE_SWP_get_copyrigth_url();
	$allowed_html = array(
		'a'		=> array(
				"href"		=> array(),
				"target"	=> array()
				),
		'br'	=> array()
		);
	if (!empty($copyrigth_text)) {
		?>
		<div class="lc_copy_area lc_swp_bg_color <?php echo esc_attr($copy_cs); ?>" data-color="<?php echo esc_attr($copy_bgc); ?>">
			<?php if (!empty($copyright_user_url)) { ?>
			<a class="transition4" href="<?php echo esc_url(LUCILLE_SWP_get_copyrigth_url()); ?>">
			<?php } ?>

				<?php echo wp_kses($copyrigth_text, $allowed_html); ?>

			<?php if (!empty($copyright_user_url)) { ?>	
			</a>
			<?php } ?>
		</div>			
		<?php
	}
 ?>