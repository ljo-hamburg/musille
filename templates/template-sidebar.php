<?php
/**
 * Template Name: With Sidebar
 * Template Post Type: post, page
 *
 * Renders a post with sidebar.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Timber;

$context = Timber::context();
Timber::render( 'template-sidebar.twig', $context );
