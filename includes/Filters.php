<?php
/**
 * Simple WordPress filter hooks.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The `Filters` class contains implementations of some WordPress filters that are used
 * to configure the Musille theme. Not all filters used by the theme use methods from
 * this class. As a rule of thumb this class contains those filters that always return
 * a static value.
 *
 * @package LJO\Musille
 */
class Filters {
	/**
	 * Private constructor. This class cannot be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Filters whether the password form should be displayed for password protected
	 * pages and posts.
	 *
	 * @param bool $flag The current state.
	 *
	 * @return bool Always returns `true`.
	 */
	public static function show_password_form( bool $flag ):bool {
		return true;
	}
}
