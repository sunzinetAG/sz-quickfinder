<?php
namespace Sunzinet\SzIndexedSearch\Utility;

/**
 * Description of the class 'SanitizeUtility.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Class GeneralUtility
 *
 * @package Sunzinet\SzIndexedSearch\Utility
 */
class SanitizeUtility implements SanitizeInterface {

	/**
	 * isSanitized
	 *
	 * @var bool $isSanitized
	 */
	protected $isSanitized = FALSE;

	/**
	 * string
	 *
	 * @var string $string
	 */
	protected $string = '';

	/**
	 * __construct
	 *
	 * @param string $string
	 * @return $this
	 */
	public function __construct($string) {
		return $this->sanitize($string);
	}

	/**
	 * quoteStr
	 *
	 * @param string $string
	 * @return $this
	 */
	public function sanitize($string) {
		$this->isSanitized = TRUE;

		$string = $GLOBALS['TYPO3_DB']->escapeStrForLike($string, 'pages');
		$this->string = $GLOBALS['TYPO3_DB']->quoteStr($string, 'pages');

		return $this;
	}

	/**
	 * isSanitized
	 *
	 * @return bool
	 */
	public function sanitized() {
		return $this->isSanitized;
	}

}
