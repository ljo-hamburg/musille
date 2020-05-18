<?php
	$header_width = esc_attr(LUCILLE_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$header_width = 'lc_swp_'.$header_width;


	/*sticky menu*/
	$header_class = '';
	if (LUCILLE_SWP_is_sticky_menu()) {
		$header_class = 'lc_sticky_menu transition4';
	}

	/*custom menu styling*/
	$page_logo = $menu_bar_bg = $menu_txt_col = "";
	$has_custom_menu_styling = LUCILLE_SWP_get_page_custom_menu_style($page_logo, $menu_bar_bg, $menu_txt_col);

	if ($has_custom_menu_styling) {
		$header_class .= ' cust_page_menu_style';
	}
?>

<header id="lc_page_header" class="<?php echo esc_attr($header_class); ?>" data-menubg="<?php echo esc_attr($menu_bar_bg); ?>" data-menucol="<?php echo esc_attr($menu_txt_col); ?>">
	<div class="header_inner lc_wide_menu <?php echo esc_attr($header_width); ?>">
		<div id="logo" class="lc_logo_centered">
			<?php
				$logo_img = LUCILLE_SWP_get_user_logo_img();
				if (!empty($logo_img)) {
					?>

					<a href="<?php echo home_url(); ?>" class="global_logo">
						<img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>">
					</a>

					<?php
				} else {
					?>

					<a href="<?php echo home_url(); ?>" class="text_logo global_logo"> <?php bloginfo('name'); ?></a>

					<?php
				}

				/*custom page related logo*/
				if (!empty($page_logo)) {
				?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="cust_page_logo">
						<img src="<?php echo esc_url($page_logo); ?>" alt="<?php bloginfo('name'); ?>">
					</a>
				<?php
				}					
			?>		
		</div>

		<div class="creative_right polylang_creative_menu">
			<?php  get_template_part('views/utils/polylang_switcher_creative'); ?>

			<div class="hmb_menu hmb_creative">
				<div class="hmb_inner">
					<span class="hmb_line hmb1 transition2"></span>
					<span class="hmb_line hmb2 transition2"></span>
					<span class="hmb_line hmb3 transition2"></span>
				</div>
			</div>
		</div>

		<div class="creative_left">
			<?php if (LUCILLE_SWP_show_search_on_menu()) { ?>
			<div class="creative_header_icon lc_search trigger_global_search">
				<span class="lnr lnr-magnifier"></span>
			</div>
			<?php } ?>

			<?php
				/*'url', 'icon'*/
				$user_profiles = array();
				$user_profiles = LUCILLE_SWP_get_available_social_profiles();

				foreach ($user_profiles as $social_profile) {
					?>
					
						<div class="creative_header_icon lc_social_icon">
							<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
								<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
							</a>
						</div>
					<?php
				}
			?>
		</div>
	</div>
	<?php 
	/*mobile menu*/
	get_template_part('views/menu/mobile_menu'); 
	?>
</header>

<?php 
	$creative_nav_class = 'creative_menu';
	if ("enabled" == LUCILLE_SWP_get_close_creative_option()) {
		$creative_nav_class .= ' close_on_click';
	}
?>

<div class="nav_creative_container transition3">
	<div class="lc_swp_boxed creative_menu_boxed">
		<div class="nav_creative_inner">
		<?php
		/*render main menu*/
		wp_nav_menu(
			array(
				'theme_location'	=> 'main-menu', 
				'container'			=> 'nav',
				'container_class'	=> $creative_nav_class
			)
		);
		?>
		</div>
	</div>
</div>