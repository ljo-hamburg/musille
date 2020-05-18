<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php get_template_part('views/favicon'); ?>

	<?php add_thickbox(); ?>
	<?php wp_head(); ?>

</head>

<body  <?php body_class(); ?>>
	<div id="lc_swp_wrapper">
		<?php
			/*main menu*/
			$menu_style = LUCILLE_SWP_get_menu_style();
			get_template_part('views/menu/'.$menu_style);

			/*heading area*/
			if (!is_page_template("template-visual-composer.php")) {
				get_template_part('views/heading_area');
			}


			$color_scheme = LUCILLE_SWP_get_default_color_scheme();
		?>

		<div id="lc_swp_content" data-minheight="200" class="<?php echo esc_attr($color_scheme); ?>">
			<?php
				/*show boxed container for woo pages*/
				if (LUCILLE_SWP_need_woo_sidebar_on_this_page()) {
					?>
					<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
					<?php
				}
			?>
		
