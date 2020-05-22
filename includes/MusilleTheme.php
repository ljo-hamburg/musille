<?php

declare(strict_types=1);

namespace LJO\Musille;

use Timber\Menu;
use Timber\Timber;

class MusilleTheme {

    private static ?MusilleTheme $instance = null;

    public static function initialize(): void {
        self::$instance = new self();
        Filters::init();
    }

    public static function getInstance(): MusilleTheme {
        if (! self::$instance) {
            self::initialize();
        }

        return self::$instance;
    }

    public function __construct() {
        add_action('after_setup_theme', [$this, 'setupI18n']);
        add_action('after_setup_theme', [$this, 'setupThemeSupport']);
        add_action('after_setup_theme', [$this, 'setupMenus']);
        add_action('init', [$this, 'initTheme']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_filter('timber/context', [$this, 'setupTimberContext']);
    }

    public function setupI18n(): void {
        // FIXME: This does probably not play well with child themes.
        // https://wordpress.stackexchange.com/questions/113391/do-child-themes-automatically-load-the-translation-from-the-parent-theme
        wp_get_theme()->load_textdomain();
    }

    public function setupThemeSupport(): void {
        add_theme_support('custom-logo');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('gutenberg', ['wide-images' => true]);
        add_theme_support('menus');
    }

    public function setupMenus(): void {
        register_nav_menus(
            [
                'main-menu'   => esc_html__('Main Menu', 'musille'),
                'footer-menu' => esc_html__('Footer Menu', 'musille'),
            ]
        );
    }

    public function initTheme(): void {
        add_post_type_support('page', 'excerpt');
    }

    public function enqueueStyles(): void {
        wp_enqueue_style('style', get_stylesheet_uri());
    }

    public function enqueueScripts(): void {
        wp_enqueue_script('musille-menu', get_stylesheet_directory_uri() . '/menu.js', ['jquery'], null, true);
    }

    public function setupTimberContext(array $context): array {
        $context['musille'] = new MusilleContext();
        return $context;
    }
}
