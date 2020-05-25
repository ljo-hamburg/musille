<?php
/**
 * Renders a page that began with including header.php.
 *
 * Third party plugins that hijack the theme will call wp_footer() to get the footer
 * template. We use this to end our output buffer (started in header.php) and render
 * into the view/page-plugin.twig template.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$context = $GLOBALS['timberContext'];
if ( ! isset( $context ) ) {
	wp_die(
		esc_html__(
			'Timber context not set in footer. Did you forget get_header()?',
			'musille'
		),
		'Template Error'
	);
}
$context['content'] = ob_get_contents();
ob_end_clean();
$templates = array( 'page-plugin.twig' );
Timber::render( $templates, $context );
