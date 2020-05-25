<?php
/**
 * Begins rendering a page. Must be ended by including footer.php.
 *
 * Third party plugins that hijack the theme will call wp_head() to get the header
 * template. We use this to start our output buffer and render into the
 * views/page-plugin.twig template in footer.php.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$GLOBALS['timberContext'] = Timber::context();
ob_start();
