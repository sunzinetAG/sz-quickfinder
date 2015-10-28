<?php
namespace Sunzinet\SzIndexedSearch\Settings;
/**
 * Description of the interface 'TyposcriptSettingsInterface.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Interface TyposcriptSettingsInterface
 *
 * @package Sunzinet\SzIndexedSearch\Provider
 */
interface TyposcriptSettingsInterface {

	/**
	 * getModel
	 *
	 * @return string
	 */
	public function getModel();

	/**
	 * getRegEx
	 *
	 * @return string
	 */
	public function getRegEx();

	/**
	 * getMaxResults
	 *
	 * @return int
	 */
	public function getMaxResults();

	/**
	 * getBreadcrumbSeparator
	 *
	 * @return string
	 */
	public function getBreadcrumbSeparator();

	/**
	 * getIncludeNavHiddenPages
	 *
	 * @return int
	 */
	public function getIncludeNavHiddenPages();

	/**
	 * getSearchfields
	 *
	 * @return string
	 */
	public function getSearchfields();

	/**
	 * getSearchString
	 *
	 * @return string
	 */
	public function getSearchString();

	/**
	 * setProperty
	 *
	 * @param string $propertyName
	 * @param mixed $value
	 * @return void
	 */
	public function setProperty($propertyName, $value);
}
