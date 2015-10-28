<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

/**
 * Description of the phpfile 'Pages.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Class File
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class File extends CustomSearch {

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * uidForeign
	 *
	 * @var int
	 */
	protected $uidForeign;

	/**
	 * breadcrumb
	 *
	 * @var string
	 */
	protected $breadcrumb;

	/**
	 * getPageId
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
	 * @return int
	 */
	public function getPageId() {
		return 1;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Returns the uidForeign
	 *
	 * @return int $uidForeign
	 */
	public function getUidForeign() {
		return $this->uidForeign;
	}

	/**
	 * Returns the breadcrumb
	 *
	 * @return string $breadcrumb
	 */
	public function getBreadcrumb() {
		return $this->breadcrumb;
	}

	/**
	 * Sets the breadcrumb
	 *
	 * @param string $breadcrumb
	 * @return $this
	 */
	public function setBreadcrumb($breadcrumb) {
		$this->breadcrumb = $breadcrumb;

		return $this;
	}

}