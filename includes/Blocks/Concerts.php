<?php
/**
 * Musille-Tweaks for WP-Concerts
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille\Blocks;

/**
 * The `Concerts` class registers a pseudo-block that adds some modifications to
 * existing blocks to improve compatibility with WP-Concerts.
 *
 * @package LJO\Musille\Blocks
 */
class Concerts {
	public const SCRIPT_HANDLE = 'musille/wp-concerts';

	/**
	 * Concerts constructor. Registers the block using the appropriate hooks. The block
	 * is only included on concert-related pages.
	 */
	public function __construct() {
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_print_scripts-post.php', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueues the appropriate scripts for Musille's modifications with WP-Concerts.
	 */
	public function enqueue_scripts(): void {
		global $post_type;
		if ( 'concert' === $post_type ) {
			$dependencies = require get_template_directory() . '/blocks/concerts.asset.php';
			wp_enqueue_script(
				self::SCRIPT_HANDLE,
				get_template_directory_uri() . '/blocks/concerts.js',
				$dependencies['dependencies'],
				$dependencies['version'],
				// We need to load the script before any other blocks are registered.
				// Since many plugins do not wait until the DOM is ready we just enqueue
				// our script in the header and hope that other blocks will be
				// registered in the body (or at least later in the header).
				false
			);
		}
	}
}
