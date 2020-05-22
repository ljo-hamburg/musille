<?php

/**
 * The template for displaying all pages.
 */

declare(strict_types=1);

use Timber\Timber;
use Timber\Post;

$context = Timber::context();

$context['post'] = new Post();
Timber::render('page.twig', $context);
