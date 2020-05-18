<?php
	$color_scheme = LUCILLE_SWP_get_default_color_scheme();
?>

<div id="sidebar" class="<?php echo esc_attr($color_scheme); ?>">
	<ul>
		<?php
		 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) {
		 }
		?>
	</ul>
</div>