<?php

/*
	Declare WooCommerce Support
*/
add_theme_support('woocommerce');


/*
	Unhook the WooCommerce Wrappers
*/
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_after_main_content', 'woocommerce_breadcrumb', 20);

/*remove sidebar*/
if (!LUCILLE_SWP_woo_has_sidebar()) {
	remove_action('woocommerce_sidebar','woocommerce_get_sidebar');	
}


/*
	Hook in own functions to display the wrappers that JamSession theme requires
*/
add_action('woocommerce_before_main_content', 'LUCILLE_SWP_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'LUCILLE_SWP_woocommerce_wrapper_end', 10);


function LUCILLE_SWP_woocommerce_wrapper_start() {

	if (LUCILLE_SWP_woo_has_sidebar()) {
		echo '<div class="lc_content_with_sidebar lc_basic_content_padding">';
	} else {
		echo '<div class="lc_content_full lc_swp_boxed lc_basic_content_padding '.esc_attr(LUCILLE_SWP_get_default_color_scheme()).'">';
	}
}

function LUCILLE_SWP_woocommerce_wrapper_end() {
	echo '</div>';
}

/* 
	Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php) 
*/
//add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment($fragments)
{
	ob_start();
	?>
	<a class="cart-contents " href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html__('View your shopping cart', 'lucille'); ?>">
		<i class="fa fa-shopping-bag" aria-hidden="true"></i>
		<span class="cart-contents-count">
			<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
		</span>
	</a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}



?>
