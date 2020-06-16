<?php
/**
 * The base template for post type archives for the concert post type. This template is
 * used to render lists of concerts.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( 'archive-concert.twig', $context );
