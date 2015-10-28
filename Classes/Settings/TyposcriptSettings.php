<?php
namespace Sunzinet\SzIndexedSearch\Settings;

/**
 * Description of the class 'TyposcriptSettings.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Class TyposcriptSettings
 *
 * @package Sunzinet\SzIndexedSearch\Settings
 */
class TyposcriptSettings implements TyposcriptSettingsInterface {

	/**
	 * model
	 *
	 * @var string $model
	 */
	protected $model = '';

	/**
	 * regEx
	 *
	 * @var string $regEx
	 */
	protected $regEx = '%|%';

	/**
	 * maxResults
	 *
	 * @var int $maxResults
	 */
	protected $maxResults = 3;

	/**
	 * breadcrumbSeparator
	 *
	 * @var string $breadcrumbSeparator
	 */
	protected $breadcrumbSeparator = '/';

	/**
	 * includeNavHiddenPages
	 *
	 * @var bool $includeNavHiddenPages
	 */
	protected $includeNavHiddenPages = FALSE;

	/**
	 * searchFields
	 *
	 * @var array $searchFields
	 */
	protected $searchFields = array(
		'title'
	);

	/**
	 * searchString
	 *
	 * @var string $searchString
	 */
	protected $searchString = '';

	/**
	 * initSettings
	 *
	 * @param array $settings
	 * @throws \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException
	 * @return void
	 */
	public function initSettings(array $settings) {
		foreach ($settings as $propertyName => $value) {
			$this->setProperty($propertyName, $value);
		}
	}

	/**
	 * getModel
	 *
	 * @return string
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * getRegEx
	 *
	 * @return string
	 */
	public function getRegEx() {
		return $this->regEx;
	}

	/**
	 * getMaxResults
	 *
	 * @return int
	 */
	public function getMaxResults() {
		return $this->maxResults;
	}

	/**
	 * getBreadcrumbSeparator
	 *
	 * @return string
	 */
	public function getBreadcrumbSeparator() {
		return $this->breadcrumbSeparator;
	}

	/**
	 * getIncludeNavHiddenPages
	 *
	 * @return int
	 */
	public function getIncludeNavHiddenPages() {
		return $this->includeNavHiddenPages;
	}

	/**
	 * getSearchfields
	 *
	 * @return array
	 */
	public function getSearchfields() {
		return $this->searchFields;
	}

	/**
	 * getSearchString
	 *
	 * @return string
	 */
	public function getSearchString() {
		return $this->searchString;
	}

	/**
	 * setProperty
	 *
	 * @param string $propertyName
	 * @param mixed $value
	 * @throws \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException
	 * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
	 * @return void
	 */
	public function setProperty($propertyName, $value) {
		if (!$this->hasProperty($propertyName)) {
			throw new \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException(
				'Property ' . $propertyName . ' does not Exist.',
				1442413257
			);
		}
		$value = self::convert(gettype($this->{$propertyName}), $value);
		$this->{$propertyName} = $value;
	}

	/**
	 * hasProperty
	 *
	 * @param string $propertyName
	 * @return bool
	 */
	protected function hasProperty($propertyName) {
		return property_exists(self::class, $propertyName);
	}

	/**
	 * convert
	 *
	 * @param mixed $type
	 * @param mixed $var
	 * @return array|bool|int|string
	 * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
	 */
	protected static function convert($type, $var) {
		switch ($type) {
			case 'string':
				return (string)$var;
			case 'integer':
				return (int)$var;
			case 'boolean':
				return (bool)$var;
			case 'array':
				return (array)explode(',', $var);
			default:
				throw new \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException(
					'Unsupportet type',
					1442418939
				);
		}

	}

}

