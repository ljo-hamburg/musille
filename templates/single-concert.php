<?php
/**
 * Renders a single post using the template-sidebar.twig template.
 *
 * @package LJO\Musille.
 */

declare(strict_types=1);

namespace LJO\Musille;

use Exception;
use LJO\WPConcerts\Concert;
use Timber\Timber;

try {
	$context            = Timber::context();
	$concert            = Concert::get( $context['post']->id );
	$context['concert'] = $concert;
	Timber::render( 'single-concert.twig', $context );
} catch ( Exception $exception ) {
	wp_die(
		esc_html__(
			'An error occurred loading the concert. This error cannot be fixed automatically.',
			'musille'
		)
	);
}
