<?php

$user_favicon = LUCILLE_SWP_get_user_favicon();

$default_favicon = get_template_directory_uri().'/core/img/favicon.ico';
if (empty($user_favicon)) {
	$user_favicon = $default_favicon;
}


if (!function_exists('wp_site_icon')) {
	/*old functionality - WordPress < 4.3 - user the theme settings favicon or default one*/
?>

	<link rel="shortcut icon" href="<?php echo esc_url($user_favicon); ?>" type="image/x-icon" />

<?php	
} else {
	/*have new functionality and have favicon defined*/
	wp_site_icon();
}

?>