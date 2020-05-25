<?php
/**
 * Template Name: No Header
 * Template Post Type: post, page
 *
 * Renders a post without header and without sidebar.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Timber;

$context = Timber::context();
Timber::render( 'template-no-header.twig', $context );
