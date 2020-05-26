<?php
/**
 * The musille custom header as a Gutenberg block.
 *
 * @package LJO\Musille\Blocks
 */

declare(strict_types=1);

namespace LJO\Musille\Blocks;

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
	}
}
