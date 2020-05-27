<?php
/**
 * Generates gettext data for WordPress from twig templates.
 *
 * Usage: wp --require=tasks/make-pot.php i18n make-twig-pot <source> <dest>
 *
 * @package LJO\Musille
 */

declare(strict_types=1);

namespace LJO\Musille;

// If we are not using WP CLI return immediately.
if ( ! class_exists( '\WP_CLI' ) ) {
	return;
}

require_once __DIR__ . '/../vendor/autoload.php';

use Exception;
use Gettext\Translations;
use Gettext\Extractors\Extractor;
use Gettext\Extractors\ExtractorInterface;
use Timber\Twig;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use WP_CLI;
use WP_CLI\I18n\IterableCodeExtractor;
use WP_CLI\I18n\MakePotCommand;
use WP_CLI\I18n\PhpCodeExtractor;

/**
 * The `TwigExtractor` extracts gettext functions from twig templates. It does this by
 * converting the templates to PHP and then running the usual PHP extractor.
 *
 * While being simple This approach works but has some caveats:
 * - Translator comments do not work as the twig parser discards comments.
 * - The line numbers in the resulting .pot correspond to the lines in the generated PHP
 *   code, not the lines in the original twig file.
 *
 * @package LJO\Musille
 */
class TwigExtractor extends Extractor implements ExtractorInterface {
	use IterableCodeExtractor;

	/**
	 * Parses a string and append the translations found in the Translations instance.
	 *
	 * @param string       $string The twig content to parse.
	 * @param Translations $translations Existing translations.
	 * @param array        $options Options for parsing. These will be passed down to
	 *                              the PHP extractor.
	 *
	 * @throws SyntaxError If the twig file cannot be parsed.
	 * @throws Exception If an error occurs when extracting gettext data from PHP.
	 */
	public static function fromString(
			$string,
			Translations $translations,
			array $options = array()
	) {
		$options += array( 'extractComments' => false );
		$twig     = new Environment( new ArrayLoader( array( '' => '' ) ) );
		// Add filters & functions from timber. If we skip this twig will not compile
		// the templates.
		$timber = new Twig();
		$timber->add_timber_filters( $twig );
		$timber->add_timber_functions( $twig );
		$timber->add_timber_escapers( $twig );
		PhpCodeExtractor::fromString(
			$twig->compileSource(
				new Source( $string, '' )
			),
			$translations,
			$options
		);
	}
}


/**
 * The make-twig-pot command wraps the make-pot command. It adds the ability to
 * extract gettext strings from twig templates.
 *
 * @throws WP_CLI\ExitException
 * @noinspection PhpUnhandledExceptionInspection
 */
WP_CLI::add_command(
	'i18n make-twig-pot',
	new class() extends MakePotCommand {
		/**
		 * Extracts strings and creates POT data. This method invokes its parent method
		 * and then appends gettext data from twig templates.
		 *
		 * @return mixed The generated translations.
		 */
		protected function extract_strings() {
			$translations = parent::extract_strings();
			try {
				$options = array(
					'include'    => $this->include,
					'exclude'    => $this->exclude,
					'extensions' => array( 'twig' ),
				);
				TwigExtractor::fromDirectory(
					$this->source,
					$translations,
					$options
				);
			} catch ( Exception $e ) {
				WP_CLI::error( $e->getMessage() );
			}

			foreach ( $this->exceptions as $translation ) {
				if ( $translations->find( $translation ) ) {
					unset( $translations[ $translation->getId() ] );
				}
			}

			if ( ! $this->skip_audit ) {
				$this->audit_strings( $translations );
			}

			return $translations;
		}
	}
);
