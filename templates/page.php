<?php
/**
 * This is the default template to display pages. It renders the template-full.twig
 * file.
 *
 * @package LJO\Musille.
 */

declare(strict_types=1);

use Timber\Timber;

$context = Timber::context();
Timber::render( 'template-full.twig', $context );
