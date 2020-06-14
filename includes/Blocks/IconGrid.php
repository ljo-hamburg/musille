<?php
/**
 * Custom Icon Grid Block
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille\Blocks;

/**
 * The `IconGrid` block displays a flex-sequence if icons, each with a link.
 *
 * @package LJO\Musille\Blocks
 */
class IconGrid {

	/**
	 * The name of the icon grid block.
	 *
	 * @var string
	 */
	public const BLOCK_NAME = 'musille/icon-grid';

	/**
	 * IconGrid constructor. Creates and registers the block.
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Registers the block's scripts.
	 */
	public function enqueue_scripts(): void {
		$dependencies = require get_template_directory() . '/blocks/icon-grid.asset.php';
		wp_register_script(
			self::BLOCK_NAME,
			get_template_directory_uri() . '/blocks/icon-grid.js',
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
}
