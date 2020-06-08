<?php
/**
 * The entry point for the plugin. In order to take advantage of composer's autoload
 * functionality we delegate initialization to the {@link \LJO\Musille\Musille}
 * class.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';

$musille                = Musille::get_instance();
$musille_update_checker = \Puc_v4_Factory::buildUpdateChecker(
	$musille->theme->get( 'ThemeURI' ),
	__FILE__
);
$musille_update_checker->getVcsApi()->enableReleaseAssets();
