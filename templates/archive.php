<?php
/**
 * The base template for post type archives. This template is used to render lists
 * of posts that are potentially augmented with the contents of a page.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( 'archive.twig', $context );
