<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

/**
 * Description of the phpfile 'User.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

/**
 * Class User
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class User extends FrontendUser implements SearchableInterface {

	/**
	 * breadcrumb
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
	 * @var string $breadcrumb
	 */
	protected $breadcrumb;

	/**
	 * getBreadcrumb
	 *
	 * @return string
	 */
	public function getBreadcrumb() {
		return $this->breadcrumb;
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
	 * getPageId
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
	 * @return int
	 */
	public function getPageId() {
		return 1;
	}

}
