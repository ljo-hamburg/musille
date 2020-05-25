<?php
/**
 * Template Name: Full
 * Template Post Type: post, page
 *
 * Renders a post without a sidebar.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Timber;

$context = Timber::context();
Timber::render( 'template-full.twig', $context );
