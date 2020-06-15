<?php
/**
 * The Staff Grid block.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille\Blocks;

/**
 * Class StaffGrid manages the staff grid block.
 *
 * @package LJO\Musille\Blocks
 */
class StaffGrid {

	/**
	 * The block name.
	 */
	public const BLOCK_NAME = 'musille/staff-grid';

	/**
	 * StaffGrid constructor. Creates and registers the block.
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Registers the block's scripts.
	 */
	public function enqueue_scripts(): void {
		$dependencies = require get_template_directory() . '/blocks/staff-grid.asset.php';
		wp_register_script(
			self::BLOCK_NAME,
			get_template_directory_uri() . '/blocks/staff-grid.js',
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
