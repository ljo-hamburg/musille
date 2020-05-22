<?php

/**
 * Renders a page that began with including header.php.
 *
 * Third party plugins that hijack the theme will call wp_footer() to get the footer template.
 * We use this to end our output buffer (started in header.php) and render into the view/page-plugin.twig template.
 */

declare(strict_types=1);

use Timber\Timber;

$timberContext = $GLOBALS['timberContext'];
if (! isset($timberContext)) {
    wp_die(esc_html__('Timber context not set in footer. Did you forget get_header()?', 'musille'), 'Template Error');
}
$timberContext['content'] = ob_get_contents();
ob_end_clean();
$templates = [ 'page-plugin.twig' ];
Timber::render($templates, $timberContext);
