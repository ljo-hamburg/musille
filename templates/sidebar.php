<?php
/**
 * This template renders the Musille sidebar using the sidebar.twig template.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Timber;

$context            = Timber::context();
$context['widgets'] = Timber::get_widgets( MusilleSidebar::$slug );
Timber::render( 'sidebar.twig', $context );

