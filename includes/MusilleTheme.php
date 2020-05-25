<?php
/**
 * The entry point of the Musille Theme.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

use LJO\Musille\Blocks\CustomHeader;
use Timber\Post;
use Timber\PostQuery;
use Timber\Site;

/**
 * The `MusilleTheme` is the main entry point of the Musille theme. On creation it
 * registers hooks in WordPress that setup the Musille theme.
 *
 * In order to access this class (for example to use its methods or to remove some
 * hooks) you can use the {@link MusilleTheme::get_instance()} method.
 *
 * @package LJO\Musille
 */
class MusilleTheme extends Site {

	/**
	 * The current instance of the `MusilleTheme`. Use
	 * {@link MusilleTheme::get_instance()} to access it.
	 *
	 * @var MusilleTheme|null
	 */
	private static ?MusilleTheme $instance = null;

	/**
	 * Initializes the Musille theme. This method must not be called more than once.
	 * Usually it is best to instead use {@link MusilleTheme::get_instance()} instead
	 * which will lazily call this method.
	 *
	 * This method must be called before any hooks are invoked as it registers the
	 * appropriate hooks for the theme.
	 */
	public static function initialize(): void {
		self::$instance = new self();
	}

	/**
	 * Returns the instance of `MusilleTheme`. If the instance does not yet exist it
	 * will be created.
	 *
	 * @return MusilleTheme
	 */
	public static function get_instance(): MusilleTheme {
		if ( ! self::$instance ) {
			self::initialize();
		}

		return self::$instance;
	}

	/**
	 * The Musille settings object.
	 *
	 * @var Settings
	 */
	public Settings $settings;

	/**
	 * The main menu of the theme.
	 *
	 * @var MainMenu
	 */
	public MainMenu $main_menu;

	/**
	 * The custom header block.
	 *
	 * @var Blocks\CustomHeader
	 */
	public Blocks\CustomHeader $header;

	/**
	 * The main sidebar.
	 *
	 * @var MusilleSidebar
	 */
	public MusilleSidebar $sidebar;

	/**
	 * The footer menu of the theme.
	 *
	 * @var FooterMenu
	 */
	public FooterMenu $footer;

	/**
	 * MusilleTheme constructor. Initializes the Musille theme.
	 */
	private function __construct() {
		parent::__construct();
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'init', array( $this, 'init_theme' ) );
		add_action( 'init', array( $this, 'register_block_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );

		add_filter( 'timber/context', array( $this, 'setupContext' ) );
		add_filter( 'widget_text', 'do_shortcode' );
		$this->settings  = new Settings();
		$this->main_menu = new MainMenu();
		$this->header    = new Blocks\CustomHeader();
		$this->sidebar   = new MusilleSidebar();
		$this->footer    = new FooterMenu();
	}

	/**
	 * Sets up basic theme features and i18n. This method is called in the
	 * `after_setup_theme` hook.
	 */
	public function setup_theme(): void {
		wp_get_theme( get_template() )->load_textdomain();

		add_theme_support( 'custom-logo' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'gutenberg', array( 'wide-images' => true ) );
		add_theme_support( 'menus' );
	}

	/**
	 * Initializes the theme. This method is called during the `init` hook.
	 */
	public function init_theme(): void {
		add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * Registers custom block styles in the Gutenberg editor.
	 */
	public function register_block_styles(): void {
		// TODO: Add heading variant with multiple colors.
		register_block_style(
			'core/button',
			array(
				'name'  => 'musille',
				'label' => __( 'Musille', 'musille' ),
			)
		);
		register_block_style(
			'core/group',
			array(
				'name'  => 'full-width',
				'label' => __( 'Full Width', 'musille' ),
			)
		);
		foreach ( array( 'post', 'page' ) as $post_type ) {
			$post_type_object           = get_post_type_object( $post_type );
			$post_type_object->template = array( array( CustomHeader::BLOCK_NAME ) );
		}
	}

	/**
	 * Enqueues additional assets for the block editor.
	 */
	public function enqueue_block_editor_assets(): void {
		wp_enqueue_style(
			'musille-editor',
			get_template_directory_uri() . '/editor.css',
			array(),
			filemtime( get_template_directory() . '/editor.css' )
		);
	}

	/**
	 * Enqueues styles and scripts to be used in the frontend.
	 */
	public function enqueue_assets(): void {
		wp_enqueue_style(
			'musille',
			get_template_directory_uri() . '/musille.css',
			array(),
			filemtime( get_template_directory() . '/musille.css' )
		);
		wp_enqueue_script(
			'musille-menu',
			get_template_directory_uri() . '/musille.js',
			array( 'jquery' ),
			filemtime( get_template_directory() . '/musille.js' ),
			true
		);
	}

	/**
	 * Filters the Timber context. The following keys are added to the context:
	 * - `site`: The `MusilleTheme` object.
	 * - `page`: A `Page` object.
	 * - `post`: For a singular post or the home page.
	 *
	 * @param array $context The Timber context.
	 *
	 * @return array The new Timber context.
	 */
	public function setupContext( array $context ): array {
		if ( is_singular() ) {
			$post = new Post();
		} elseif ( is_home() ) {
			$post = new Post( get_option( 'page_for_posts' ) );
		} else {
			$post = null;
		}
		$context['site'] = $this;
		$context['post'] = apply_filters( 'musille/post', $post );
		$context['page'] = apply_filters( 'musille/page', new Page( $context['post'] ) );
		return $context;
	}

	/**
	 * Returns the current copyright string for the site from the customizer.
	 *
	 * @return string The copyright string.
	 */
	public function copyright(): string {
		return $this->settings->get( Settings::COPYRIGHT_KEY );
	}
}
