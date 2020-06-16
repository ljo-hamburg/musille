<?php
/**
 * An object representing the current page.
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

if ( ! defined( 'WPINC' ) ) {
	die;
}

use LJO\Musille\Blocks\CustomHeader;
use Timber\Image;
use Timber\Post;
use WP_Query;

/**
 * An object of the `Page` class wraps the current `Post` object providing fallbacks
 * for pages that are not associated with a single post.
 *
 * @package LJO\Musille
 */
class Page {

	/**
	 * The `Page` instance representing the current page.
	 *
	 * @var Page|null
	 */
	private static ?Page $current_page = null;

	/**
	 * Returns the singleton instance of the current page. This is the preferred way of
	 * obtaining a `Page` instance.
	 *
	 * @return Page
	 */
	public static function current(): Page {
		if ( ! isset( self::$current_page ) ) {
			self::$current_page = new Page();
		}
		return self::$current_page;
	}

	/**
	 * The query that this page represents.
	 *
	 * @var WP_Query
	 */
	public WP_Query $query;

	/**
	 * The post object representing the single post for this page. For singular pages
	 * this is the singular post object. For other pages this object might be set to the
	 * post object for a page that is associated with that URL. For example for an
	 * archive page this might be set to the post with the same URL as the archive page.
	 *
	 * @var Post|null
	 */
	public ?Post $post = null;

	/**
	 * Page constructor. Creates a new `Page` object representing the specified query.
	 *
	 * @param WP_Query|null $query The query represented by this page. If this is falsey
	 *                             the main query is used.
	 */
	protected function __construct( ?WP_Query $query = null ) {
		if ( ! isset( $query ) ) {
			global $wp_query;
			$query = $wp_query;
		}
		$this->query = $query;
		$this->initialize( $query );
	}

	/**
	 * Initializes the page with the specified query.
	 *
	 * @param WP_Query $query The same as `$this->query`.
	 */
	protected function initialize( WP_Query $query ) {
		if ( $query->is_singular() ) {
			$this->post = new Post( $query->get_queried_object_id() );
		} elseif ( $query->is_home() ) {
			$this->post = new Post( get_option( 'page_for_posts' ) );
		} elseif ( $query->is_post_type_archive() ) {
			$post           = null;
			$queried_object = $query->get_queried_object();
			$slug           = $queried_object->has_archive;
			if ( ! is_string( $slug ) ) {
				$slug = $queried_object->rewrite['slug'];
			}
			if ( ! is_string( $slug ) ) {
				$slug = $queried_object->name;
			}
			$page_data  = get_page_by_path( $slug );
			$this->post = $page_data ? new Post( $page_data->ID ) : null;
		}
	}

	/**
	 * Returns a boolean value indicating whether this page is associated with a single
	 * post object.
	 *
	 * @return bool `true` if there is a single post that represents the current page,
	 *              `false` otherwise.
	 */
	public function has_post(): bool {
		return boolval( $this->post );
	}

	/**
	 * Returns an `Image` that is to be used for this page's header background.
	 *
	 * @return Image|null The header background or `null` if no background image exists.
	 */
	public function header_background(): ?Image {
		if ( ! in_array( $this->header_style(), array( 'subtitle', 'fancy' ), true ) ) {
			return null;
		}
		if ( $this->has_post() ) {
			$image_id = $this->post->meta( CustomHeader::IMAGE_ID_META_KEY );
			if ( $image_id ) {
				$background = new Image( $image_id );
			} else {
				$background = $this->post->thumbnail();
			}
		} else {
			$background = null;
		}

		/**
		 * Filters the background image display on a page.
		 *
		 * @param Image $background The background as specified by the post.
		 * @param Page $page The page for which to filter the background.
		 */
		return apply_filters( 'musille/header_background', $background, $this );
	}

	/**
	 * Returns the attribution for the header image as it should be displayed. This
	 * method takes into account whether the user has disabled the attribution.
	 *
	 * @return string The attribution or the empty string if no attribution exists or
	 *                the user has disabled the attribution.
	 */
	public function header_attribution(): string {
		if ( $this->has_post() ) {
			$show_attribution = $this->post->meta( CustomHeader::SHOW_ATTRIBUTION_META_KEY );
		} else {
			/**
			 * Filters the default value for whether to show an attribution text or not.
			 *
			 * @param bool $value `false` by default.
			 * @param Page $page The page for which to filter the attribution flag.
			 */
			$show_attribution = apply_filters( 'musille/show_header_attribution', false, $this );
		}

		if ( $show_attribution ) {
			$background  = $this->header_background();
			$attribution = $background ? $background->caption : '';
		} else {
			$attribution = '';
		}
		/**
		 * Filters the header background attribution before it is displayed.
		 *
		 * @param string $attribution The attribution from the displayed image or the
		 *                            empty string if no attribution exists.
		 * @param Page $page The page for which to filter the attribution value.
		 */
		return apply_filters( 'musille/header_attribution', $attribution, $this );
	}

	/**
	 * Returns the style that should be used for the header block. Available styles
	 * include: `basic`, `subtitle`, `colored`, and `fancy`.
	 *
	 * @return string A string identifying the header style for the current page.
	 */
	public function header_style(): string {
		if ( $this->has_post() ) {
			$style = $this->post->meta( CustomHeader::HEADER_STYLE_META_KEY ) ?? 'basic';
		} elseif ( $this->query->is_404() ) {
			$style = 'fancy';
		} else {
			$style = 'basic';
		}

		/**
		 * Filters the header style that is used on a page.
		 *
		 * @param string $style The header style as specified by the post or `'basic'`
		 *                      for all other pages.
		 * @param Page $page The page for which to filter the header style.
		 */
		return apply_filters( 'musille/header_style', $style, $this );
	}

	/**
	 * Returns the title for the current page.
	 *
	 * @return string The page title.
	 */
	public function title(): string {
		if ( $this->has_post() ) {
			$title = $this->post->title();
		} elseif ( $this->query->is_search() ) {
			$title = __( 'Search', 'musille' );
		} elseif ( $this->query->is_404() ) {
			$title = __( '404', 'musille' );
		} elseif ( $this->query->is_archive() ) {
			// FIXME: This only works for the main query.
			$title = get_the_archive_title();
		} else {
			$title = get_the_title();
		}

		/**
		 * Filters the page title before it is displayed.
		 *
		 * @param string $title The default title.
		 * @param Page $page The page for which to filter the title.
		 */
		return apply_filters( 'musille/title', $title, $this );
	}

	/**
	 * Returns the subtitle for the current page.
	 *
	 * @return string The page subtitle.
	 */
	public function subtitle(): string {
		if ( $this->has_post() ) {
			$subtitle = $this->post->meta( CustomHeader::SUBTITLE_META_KEY ) ?? '';
		} elseif ( $this->query->is_search() ) {
			// Translators: Page title for search results.
			$subtitle = sprintf( __( 'Results for "%s"', 'musille' ), get_search_query() );
		} elseif ( $this->query->is_404() ) {
			$subtitle = __( 'Page not found', 'musille' );
		} else {
			$subtitle = '';
		}

		/**
		 * Filters the subtitle before it is displayed.
		 *
		 * @param string $subtitle The subtitle configured by the post.
		 * @param Page $page The page for which to filter the subtitle.
		 */
		return apply_filters( 'musille/subtitle', $subtitle, $this );
	}
}
