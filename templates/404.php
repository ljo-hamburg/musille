<?php
/**
 * The template for 404 errors. This template renders the 404.twig template.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( '404.twig', $context );
