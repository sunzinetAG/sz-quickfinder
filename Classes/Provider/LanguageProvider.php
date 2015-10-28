<?php
namespace Sunzinet\SzIndexedSearch\Provider;

/**
 * Provides Methods for Language Handling. Useful for Ajax Requests
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Class LanguageProvider
 *
 * @package Sunzinet\SzIndexedSearch\Provider
 * @deprecated since 3.0.0 will be removed in 3.1.0
 */
class LanguageProvider {

	/**
	 * objectManager
	 *
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 * @inject
	 */
	protected $objectManager;

	/**
	 * manipulateGlobals
	 *
	 * @param string $languageKey
	 * @deprecated since 3.0.0 will be removed in 3.1.0
	 * @return void
	 */
	public function setLanguage($languageKey = '') {
		if (!is_string($languageKey)) {
			throw new \InvalidArgumentException('Parameter $searchString must be of type string', 1440585046);
		}

		if ($languageKey === '') {
			throw new \InvalidArgumentException('Given String must not be Empty', 1440581637);
		}

		$languageService = $this->objectManager->get(LanguageService::class);
		$languageService->init($languageKey);
		$GLOBALS['LANG'] = $languageService;
	}

	/**
	 * getLanguageKey
	 *
	 * @deprecated since 3.0.0 will be removed in 3.1.0
	 * @return string
	 */
	public function getLanguageKey() {
		return $GLOBALS['LANG']->lang;
	}

	/**
	 * getCharset
	 *
	 * @deprecated since 3.0.0 will be removed in 3.1.0
	 * @return string
	 */
	public function getCharset() {
		return $GLOBALS['LANG']->charSet;
	}

	/**
	 * getLanguageUid
	 *
	 * @deprecated since 3.0.0 will be removed in 3.1.0
	 * @return mixed
	 */
	public function getLanguageUid() {
		return GeneralUtility::_GP('L');
	}

}
