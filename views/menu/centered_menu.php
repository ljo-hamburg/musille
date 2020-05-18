<?php
	$header_width = esc_attr(LUCILLE_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$header_width = 'lc_swp_'.$header_width; 

	/*sticky menu*/
	$header_class = '';
	if (LUCILLE_SWP_is_sticky_menu()) {
		$header_class = 'lc_sticky_menu';
	}

	/*custom menu styling*/
	$page_logo = $menu_bar_bg = $menu_txt_col = "";
	$has_custom_menu_styling = LUCILLE_SWP_get_page_custom_menu_style($page_logo, $menu_bar_bg, $menu_txt_col);

	if ($has_custom_menu_styling) {
		$header_class .= ' cust_page_menu_style';
	}	
?>

<header id="lc_page_header" class="<?php echo esc_attr($header_class); ?>" data-menubg="<?php echo esc_attr($menu_bar_bg); ?>" data-menucol="<?php echo esc_attr($menu_txt_col); ?>">
	<div class="header_inner centered_menu lc_wide_menu <?php echo esc_attr($header_width); ?>">
		<div class="centered_content">
			<div id="logo" class="centered_menu">
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

						<a href="<?php echo home_url(); ?>" class="global_logo"> <?php bloginfo('name'); ?></a>

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

			<?php
			/*render main menu*/
			wp_nav_menu(
				array(
					'theme_location'	=> 'main-menu', 
					'container'			=> 'nav',
					'container_class'	=> 'centered_menu classic_menu'
				)
			);
			?>

			<div class="classic_header_icons centered_menu">
				<?php if (LUCILLE_SWP_show_search_on_menu()) { ?>
				<div class="classic_header_icon centered_menu lc_search trigger_global_search vibrant_hover transition4">
					<span class="lnr lnr-magnifier"></span>
				</div>
				<?php } ?>

				<?php 
				if (LUCILLE_SWP_is_woocommerce_active()) {
				?>

					<div class="classic_header_icon centered_menu shop_icon">
						<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html__('View your shopping cart', 'lucille'); ?>">
							<i class="fa fa-shopping-bag" aria-hidden="true"></i>
							<span class="cart-contents-count lc_swp_vibrant_bgc">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
							</span>
						</a>
					</div>
					
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php 
	/*mobile menu*/
	get_template_part('views/menu/mobile_menu'); 
	?>
</header>