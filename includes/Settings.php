<?php
/**
 * The theme settings for the Musille theme.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use WP_Customize_Manager;

/**
 * The `Settings` class keeps track of the theme settings in the customizer.
 *
 * @package LJO\Musille
 */
class Settings {

	/**
	 * The key under which the copyright string is stored.
	 */
	public const COPYRIGHT_KEY = 'musille-copyright';

	/**
	 * Settings constructor. Creates a new `Settings` object and registers it in the
	 * customizer.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'setup_customizer' ) );
	}

	/**
	 * Adds the appropriate controls to the WordPress customizer. This method is called
	 * in the `customize_register` hook.
	 *
	 * @param WP_Customize_Manager $wp_customize The WordPress customizer.
	 */
	public function setup_customizer( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_setting( self::COPYRIGHT_KEY );
		$wp_customize->add_control(
			self::COPYRIGHT_KEY,
			array(
				'type'        => 'text',
				'section'     => 'title_tagline',
				'label'       => __( 'Copyright', 'musille' ),
				'description' => __(
					'The copyright notice to be displayed in the page footer.',
					'musille'
				),
			)
		);
	}

	/**
	 * Fetches the value for the specified setting. Available values are documented as
	 * constants on the {@link Settings} class.
	 *
	 * @param string $key The key for which to fetch the value.
	 * @param bool   $default A default value to return if the `$key` does not have a
	 *                        value.
	 *
	 * @return mixed The value for `$key`.
	 */
	public function get( string $key, $default = false ) {
		return get_theme_mod( $key, $default );
	}
}
