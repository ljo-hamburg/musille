<?php
/**
 * The footer menu in the musille theme.
 *
 * @package LJO\Musille.
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

use Timber\Menu;

/**
 * The `FooterMenu` class represents the footer menu in the musille theme. The menu is
 * automatically registered. Currently only a depth of 1 is supported.
 *
 * @package LJO\Musille
 */
class FooterMenu extends Menu {

	/**
	 * The slug of the menu.
	 *
	 * @var string
	 */
	public const SLUG = 'footer';

	/**
	 * FooterMenu constructor. Creates and registers the menu.
	 */
	public function __construct() {
		parent::__construct(
			self::SLUG,
			array(
				'depth' => 1,
			)
		);
		add_action( 'after_setup_theme', array( $this, 'register_menu' ) );
		add_filter( 'timber/context', array( $this, 'setup_context' ) );
	}

	/**
	 * Registers the menu in WordPress. Called during the `after_setup_theme` hook.
	 */
	public function register_menu(): void {
		register_nav_menu( self::SLUG, esc_html__( 'Footer Menu', 'musille' ) );
	}

	/**
	 * Adds the menu to the Timber context.
	 *
	 * @param array $context The current timber context.
	 * @return array `$context` with the `footer` menu added.
	 */
	public function setup_context( array $context ): array {
		$context['footer'] = $this;
		return $context;
	}
}
