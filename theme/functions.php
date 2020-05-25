<?php
/**
 * The entry point for the plugin. In order to take advantage of composer's autoload
 * functionality we delegate initialization to the {@link \LJO\Musille\MusilleTheme}
 * class.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use LJO\Musille\MusilleTheme;

require_once __DIR__ . '/vendor/autoload.php';
MusilleTheme::initialize();
