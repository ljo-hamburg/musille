<?php
/**
 * The main sidebar of the Musille theme.
 *
 * @package LJO\Musille.
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The `MusilleSidebar` registers the main sidebar of the musille theme.
 *
 * @package LJO\Musille
 */
class MusilleSidebar {
	/**
	 * The slug of the main sidebar.
	 *
	 * @var string
	 */
	public const SLUG = 'main-sidebar';

	/**
	 * MusilleSidebar constructor. Creates and registers the sidebar.
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
	}

	/**
	 * Registers the sidebar in WordPress. This method is called in the `widgets_init`
	 * hook.
	 */
	public function register_sidebar() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Main MusilleSidebar', 'musille' ),
				'id'            => self::SLUG,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
