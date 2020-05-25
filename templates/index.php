<?php
/**
 * The base template in the template hierarchy. This template is used to render lists
 * of posts (e.g. search results or the latest posts). It renders the index.twig file.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( 'index.twig', $context );
