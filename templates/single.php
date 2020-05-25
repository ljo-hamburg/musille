<?php
/**
 * Renders a single post using the template-sidebar.twig template.
 *
 * @package LJO\Musille.
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( 'template-sidebar.twig', $context );
