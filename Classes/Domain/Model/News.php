<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

	/**
	 * Description of the class 'News.php'
	 *
	 * @author Dennis Römmich <dennis@roemmich.eu>
	 * @copyright Copyright belongs to the respective authors
	 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
	 */

/**
 * Class News
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class News extends \GeorgRinger\News\Domain\Model\News implements SearchableInterface {

	/**
	 * breadcrumb
	 *
	 * @var string $breadcrumb
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
	 * setBreadcrumb
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
	 * @param string $breadcrumb
	 * @return $this
	 */
	public function setBreadcrumb($breadcrumb) {
		$this->breadcrumb = $breadcrumb;

		return $this;
	}

	/**
	 * getBreadcrumb
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
	 * @return string
	 */
	public function getBreadcrumb() {
		return $this->breadcrumb;
	}
}
