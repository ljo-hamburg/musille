<?php
/**
 * The entry point of the Musille Theme.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

use Timber\Post;
use Timber\Site;
use Timber\Timber;
use WP_Post_Type;

/**
 * The `MusilleTheme` is the main entry point of the Musille theme. On creation it
 * registers hooks in WordPress that setup the Musille theme.
 *
 * In order to access this class (for example to use its methods or to remove some
 * hooks) you can use the {@link Musille::get_instance()} method.
 *
 * @package LJO\Musille
 */
class Musille extends Site {

	/**
	 * The current instance of the `MusilleTheme`. Use
	 * {@link Musille::get_instance()} to access it.
	 *
	 * @var Musille|null
	 */
	private static ?Musille $instance = null;

	/**
	 * Initializes the Musille theme. This method must not be called more than once.
	 * Usually it is best to instead use {@link Musille::get_instance()} instead
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
	 * @return Musille
	 */
	public static function get_instance(): Musille {
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
	 * The block-pseudo class that modifies existing blocks for the concerts theme.
	 *
	 * @var Blocks\Concerts
	 */
	public Blocks\Concerts $concerts_block;

	/**
	 * The icon grid block.
	 *
	 * @var Blocks\IconGrid
	 */
	public Blocks\IconGrid $icon_grid_block;

	/**
	 * The staff grid block.
	 *
	 * @var Blocks\StaffGrid
	 */
	public Blocks\StaffGrid $staff_grid_block;

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
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		add_filter( 'document_title_parts', array( $this, 'filter_document_title' ) );

		add_filter( 'timber/context', array( $this, 'setupContext' ) );
		add_filter(
			'timber/post/content/show_password_form_for_protected',
			array(
				Filters::class,
				'show_password_form',
			)
		);
		add_filter( 'widget_text', 'do_shortcode' );
		$this->settings         = new Settings();
		$this->main_menu        = new MainMenu();
		$this->header           = new Blocks\CustomHeader();
		$this->concerts_block   = new Blocks\Concerts();
		$this->icon_grid_block  = new Blocks\IconGrid();
		$this->staff_grid_block = new Blocks\StaffGrid();
		$this->sidebar          = new MusilleSidebar();
		$this->footer           = new FooterMenu();
	}

	/**
	 * Sets up basic theme features and i18n. This method is called in the
	 * `after_setup_theme` hook.
	 */
	public function setup_theme(): void {
		wp_get_theme( get_template() )->load_textdomain();

		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'gutenberg', array( 'wide-images' => true ) );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'gallery', 'caption' ) );
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary', 'musille' ),
					'slug'  => 'primary',
					'color' => '#32373c',
				),
				array(
					'name'  => esc_html__( 'Accent', 'musille' ),
					'slug'  => 'accent',
					'color' => '#d15254',
				),
				array(
					'name'  => esc_html__( 'Link', 'musille' ),
					'slug'  => 'link',
					'color' => '#0693e3',
				),
				array(
					'name'  => esc_html__( 'Dark', 'musille' ),
					'slug'  => 'dark',
					'color' => '#2a2a2a',
				),
				array(
					'name'  => esc_html__( 'White', 'musille' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => esc_html__( 'Black', 'musille' ),
					'slug'  => 'black',
					'color' => '#000',
				),
			)
		);
	}

	/**
	 * Initializes the theme. This method is called during the `init` hook.
	 */
	public function init_theme(): void {
		add_post_type_support( 'page', 'excerpt' );
		wp_register_style(
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css',
			array(),
			'5.13.0'
		);
	}

	/**
	 * Registers custom block styles in the Gutenberg editor.
	 */
	public function register_block_styles(): void {
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
				'name'  => 'full-bg',
				'label' => __( 'Full Background', 'musille' ),
			)
		);
		register_block_style(
			'core/group',
			array(
				'name'  => 'full-width',
				'label' => __( 'Full Width', 'musille' ),
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'  => 'section',
				'label' => __( 'Section Heading', 'musille' ),
			)
		);
		register_block_style(
			'core/social-links',
			array(
				'name'  => 'large-white',
				'label' => __(
					'Large & White',
					'musille'
				),
			)
		);
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'fancy',
				'label' => __(
					'Fancy',
					'musille'
				),
			)
		);
		foreach ( array( 'post', 'page' ) as $post_type ) {
			$post_type_object           = get_post_type_object( $post_type );
			$post_type_object->template = array( array( Blocks\CustomHeader::BLOCK_NAME ) );
		}
	}

	/**
	 * Enqueues additional assets for the block editor.
	 */
	public function enqueue_block_editor_assets(): void {
		wp_enqueue_style(
			'musille-editor',
			get_template_directory_uri() . '/editor.css',
			array( 'font-awesome' ),
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
			array( 'font-awesome' ),
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
	 * Enqueue styles and scripts to be used in the backend.
	 */
	public function enqueue_admin_assets(): void {
		wp_enqueue_style(
			'musille-admin',
			get_template_directory_uri() . '/admin.css',
			array(),
			filemtime( get_template_directory() . '/admin.css' )
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
			$post           = null;
			$queried_object = get_queried_object();
			if ( $queried_object instanceof WP_Post_Type ) {
				$slug = $queried_object->has_archive;
				if ( ! is_string( $slug ) ) {
					$slug = $queried_object->rewrite['slug'];
				}
				if ( ! is_string( $slug ) ) {
					$slug = $queried_object->name;
				}
				$page_data = get_page_by_path( $slug );
				$post      = $page_data ? new Post( $page_data->ID ) : null;
			}
		}
		$context['site'] = $this;
		$context['post'] = apply_filters( 'musille/post', $post );
		$context['page'] = apply_filters( 'musille/page', new Page( $context['post'] ) );
		return $context;
	}

	/**
	 * Filters the document title. If the user has created a page living at the same
	 * path as another part of the site that page should override the title. This filter
	 * ensures that this is the case.
	 *
	 * @param array $title The current document title components.
	 *
	 * @return array The modified document title components.
	 */
	public function filter_document_title( array $title ): array {
		$context = Timber::context();
		$page    = $context['page'];
		if ( ! is_front_page() && $page ) {
			$title['title'] = $page->title();
		}
		return $title;
	}

	/**
	 * Returns a boolean value indicating whether the admin bar is currently visible.
	 *
	 * @return bool Whether the admin bar is visible.
	 */
	public function admin_bar_showing(): bool {
		return is_admin_bar_showing();
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
