<?php
/**
 * The main menu in the musille theme.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Image;
use Timber\Menu;

/**
 * THe `MainMenu` class represents the main menu in the musille theme. The menu is
 * automatically registered. Currently only a depth of 2 is supported.
 *
 * @package LJO\Musille
 */
class MainMenu extends Menu {

	/**
	 * The slug of the menu.
	 */
	public const SLUG = 'main-menu';

	/**
	 * MainMenu constructor. Creates and registers the menu.
	 */
	public function __construct() {
		parent::__construct( self::SLUG, array( 'depth' => 2 ) );
		add_action( 'after_setup_theme', array( $this, 'register_menu' ) );
		add_filter( 'timber/context', array( $this, 'setup_context' ) );
	}

	/**
	 * Registers the menu in WordPress. Called during the `after_setup_theme` hook.
	 */
	public function register_menu(): void {
		register_nav_menu( self::SLUG, esc_html__( 'Main Menu', 'musille' ) );
	}

	/**
	 * Returns the website logo.
	 *
	 * @return Image The website logo.
	 */
	public function logo(): string {
		return get_custom_logo();
	}

	/**
	 * Returns the menu items on the left of the logo. If the menu contains a `<logo />`
	 * marker it is used as the separator. Otherwise the menu is split in half.
	 *
	 * @return array The menu items on the left of the logo.
	 */
	public function left_items(): array {
		$items = array();
		foreach ( $this->get_items() as $item ) {
			if ( '<logo />' === $item->name ) {
				return $items;
			}
			$items[] = $item;
		}
		return array_slice( $items, 0, intdiv( count( $items ) + 1, 2 ) );
	}

	/**
	 * Returns the menu items on the right of the logo. If the menu contains a
	 * `<logo />` marker it is used as the seaprator. Otherwise the menu is split in
	 * half.
	 *
	 * @return array The menu items on the right of the logo.
	 */
	public function right_items(): array {
		$items = array();
		foreach ( $this->get_items() as $item ) {
			if ( '<logo />' === $item->name ) {
				$items = array();
			} else {
				$items[] = $item;
			}
		}
		if ( count( $items ) !== count( $this->get_items() ) ) {
			return $items;
		} else {
			return array_slice(
				$items,
				intdiv( count( $items ) + 1, 2 ),
				intdiv( count( $items ), 2 )
			);
		}
	}

	/**
	 * Adds the menu to the Timber context.
	 *
	 * @param array $context The current Timber context.
	 *
	 * @return array `$context` including the `main_menu`.
	 */
	public function setup_context( array $context ): array {
		$context['main_menu'] = $this;
		return $context;
	}
}
