<?php
/**
 * The musille custom header as a Gutenberg block.
 *
 * @package LJO\Musille\Blocks
 */

declare(strict_types=1);

namespace LJO\Musille\Blocks;

use LJO\WPConcerts\Concert;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The `CustomHeader` class registers the respective Gutenberg block that allows users
 * to modify the default theme header.
 *
 * @package LJO\Musille\Blocks
 */
class CustomHeader {

	/**
	 * The name of the block as registered in the editor.
	 *
	 * @var string
	 */
	public const BLOCK_NAME = 'musille/header';

	/**
	 * The key in the post metadata under which the custom header image is stored.
	 *
	 * @var string
	 */
	public const IMAGE_ID_META_KEY = 'musille_header_image_id';

	/**
	 * The key in the post metadata under which the post subtitle is stored.
	 *
	 * @var string
	 */
	public const SUBTITLE_META_KEY = 'musille_subtitle';

	/**
	 * The key in the post metadata under which the header style is stored.
	 *
	 * @var string
	 */
	public const HEADER_STYLE_META_KEY = 'musille_header_style';

	/**
	 * The key in the post metadata under which the show attribution flag is stored.
	 *
	 * @var string
	 */
	public const SHOW_ATTRIBUTION_META_KEY = 'musille_show_attribution';

	/**
	 * `CustomHeader` constructor. This method registers the appropriate hooks making
	 * the block available in the editor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_concerts/load_meta', array( $this, 'init_concert' ) );
		add_filter( 'wp_concerts/subtitle', array( $this, 'concert_subtitle' ), 10, 2 );
	}

	/**
	 * Initializes the block and adds it to the editor.
	 */
	public function init(): void {
		// Register meta fields.
		register_post_meta(
			'',
			self::IMAGE_ID_META_KEY,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'integer',
			)
		);
		register_post_meta(
			'',
			self::SUBTITLE_META_KEY,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
		register_post_meta(
			'',
			self::HEADER_STYLE_META_KEY,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
		register_post_meta(
			'',
			self::SHOW_ATTRIBUTION_META_KEY,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'boolean',
			)
		);
		/**
		 * Register the actual block.
		 *
		 * @noinspection PhpIncludeInspection
		 */
		$dependencies = require get_template_directory() . '/blocks/header.asset.php';
		wp_register_script(
			self::BLOCK_NAME,
			get_template_directory_uri() . '/blocks/header.js',
			$dependencies['dependencies'],
			$dependencies['version'],
			true
		);
		register_block_type(
			self::BLOCK_NAME,
			array(
				'editor_script' => self::BLOCK_NAME,
			)
		);
		wp_set_script_translations(
			self::BLOCK_NAME,
			'musille',
			get_template_directory() . '/languages'
		);
	}

	/**
	 * This hook is called when a `Concert` instance is created. If the user has set a
	 * custom header image for a concert we add it to the concert images here, so it is
	 * available in the structured data as well.
	 *
	 * @param Concert $concert The concert instance.
	 */
	public function init_concert( Concert $concert ) {
		$image_id = get_post_meta( $concert->id, self::IMAGE_ID_META_KEY, true );
		if ( isset( $image_id ) ) {
			$image = wp_get_attachment_image_src( $image_id, 'full' );
			if ( isset( $image[0] ) ) {
				$concert->image_urls[] = $image[0];
			}
		}
	}

	/**
	 * Returns the subtitle for a concert based on the custom header. This integrates
	 * the custom header with WP Concerts.
	 *
	 * @param string|null $subtitle The existing subtitle.
	 * @param Concert     $concert The concert for which to get the subtitle.
	 * @return string The subtitle for $concert.
	 */
	public function concert_subtitle( ?string $subtitle, Concert $concert ): ?string {
		return get_post_meta( $concert->id, self::SUBTITLE_META_KEY, true );
	}
}
