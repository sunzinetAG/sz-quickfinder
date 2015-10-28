<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

/**
 * Description of the interface 'SearchableInterface.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Interface SearchableInterface
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
interface SearchableInterface {

	/**
	 * getBreadcrumb
	 *
	 * @return string
	 */
	public function getBreadcrumb();

	/**
	 * getPageId
	 *
	 * @return integer
	 */
	public function getPageId();

	/**
	 * setSearchString
	 *
	 * @param string $searchString
	 * @return $this
	 */
	public function setSearchString($searchString);

	/**
	 * getSearchString
	 *
	 * @return string
	 */
	public function getSearchString();

	/**
	 * setPid
	 *
	 * @param integer $id
	 * @return void
	 */
	public function setPid($id);

	/**
	 * getPid
	 *
	 * @return integer
	 */
	public function getPid();

}