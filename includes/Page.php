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

use Cassandra\Custom;
use LJO\Musille\Blocks\CustomHeader;
use Timber\Image;
use Timber\Post;

/**
 * An object of the `Page` class wraps the current `Post` object providing fallbacks
 * for pages that are not associated with a single post.
 *
 * @package LJO\Musille
 */
class Page {

	/**
	 * The post associated with the current page, if any.
	 *
	 * @var Post|null
	 */
	public ?Post $post;

	/**
	 * Page constructor. Creates a new `Page` object representing the specified post.
	 *
	 * @param Post|null $post The post that this page represents or `null` if this page
	 *                        is not associated with a single post object.
	 */
	public function __construct( ?Post $post ) {
		$this->post = $post;
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
		 */
		return apply_filters( 'musille/header_background', $background );
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
			 */
			$show_attribution = apply_filters( 'musille/show_header_attribution', false );
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
		 */
		return apply_filters( 'musille/header_attribution', $attribution );
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
		} elseif ( is_404() ) {
			$style = 'fancy';
		} else {
			$style = 'basic';
		}

		/**
		 * Filters the header style that is used on a page.
		 *
		 * @param string $style The header style as specified by the post or `'basic'`
		 *                      for all other pages.
		 */
		return apply_filters( 'musille/header_style', $style );
	}

	/**
	 * Returns the title for the current page.
	 *
	 * @return string The page title.
	 */
	public function title(): string {
		if ( $this->has_post() ) {
			$title = $this->post->title();
		} elseif ( is_search() ) {
			$title = __( 'Search', 'musille' );
		} elseif ( is_404() ) {
			$title = __( '404', 'musille' );
		} else {
			$title = get_the_archive_title();
		}

		/**
		 * Filters the page title before it is displayed.
		 *
		 * @param string $title The default title.
		 */
		return apply_filters( 'musille/title', $title );
	}

	/**
	 * Returns the subtitle for the current page.
	 *
	 * @return string The page subtitle.
	 */
	public function subtitle(): string {
		if ( $this->has_post() ) {
			$subtitle = $this->post->meta( CustomHeader::SUBTITLE_META_KEY ) ?? '';
		} elseif ( is_search() ) {
			// Translators: Page title for search results.
			$subtitle = sprintf( __( 'Results for "%s"', 'musille' ), get_search_query() );
		} elseif ( is_404() ) {
			$subtitle = __( 'Page not found', 'musille' );
		} else {
			$subtitle = '';
		}

		/**
		 * Filters the subtitle before it is displayed.
		 *
		 * @param string $subtitle The subtitle configured by the post.
		 */
		return apply_filters( 'musille/subtitle', $subtitle );
	}
}
