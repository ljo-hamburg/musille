<?php
	$mobile_header_width = esc_attr(LUCILLE_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$mobile_header_width = 'lc_swp_'.$mobile_header_width; 
?>
<div class="header_inner lc_mobile_menu <?php echo esc_attr($mobile_header_width); ?>">
	<div id="mobile_logo" class="lc_logo_centered">
		<?php
			$logo_img = LUCILLE_SWP_get_user_logo_img();
			if (!empty($logo_img)) {
				?>

				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>">
				</a>

				<?php
			} else {
				?>

				<a href="<?php echo home_url(); ?>"> <?php bloginfo('name'); ?></a>

				<?php
			}
		?>		
	</div>

	<div class="creative_right">
		<?php  get_template_part('views/utils/polylang_switcher_mobile'); ?>

		<div class="hmb_menu hmb_mobile">
			<div class="hmb_inner">
				<span class="hmb_line hmb1 transition2 mobile_hmb_line"></span>
				<span class="hmb_line hmb2 transition2 mobile_hmb_line"></span>
				<span class="hmb_line hmb3 transition2 mobile_hmb_line"></span>
			</div>
		</div>
	</div>

	<div class="creative_left">
		<?php if (LUCILLE_SWP_show_search_on_menu()) { ?>
		<div class="mobile_menu_icon creative_header_icon lc_search trigger_global_search">
			<span class="lnr lnr-magnifier lnr_mobile"></span>
		</div>
		<?php } ?>

		<?php
			/*'url', 'icon'*/
			$user_profiles = array();
			$user_profiles = LUCILLE_SWP_get_available_social_profiles();

			foreach ($user_profiles as $social_profile) {
				?>
				
					<div class="mobile_menu_icon creative_header_icon lc_social_icon">
						<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank" class="mobile_menu_icon">
							<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
						</a>
					</div>
				<?php
			}
		?>
	</div>
</div>

<div class="mobile_navigation_container lc_swp_full transition3">
	<?php
	/*render main menu*/
	wp_nav_menu(
		array(
			'theme_location'	=> 'main-menu', 
			'container'			=> 'nav',
			'container_class'	=> 'mobile_navigation'
		)
	);
	?>
</div>
