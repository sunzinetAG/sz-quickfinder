<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

/**
 * Description of the phpfile 'User.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */

/**
 * Class Content
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class Content extends CustomSearch {

	/**
	 * header
	 *
	 * @var string
	 */
	protected $header;

	/**
	 * bodytext
	 *
	 * @var string
	 */
	protected $bodytext;

	/**
	 * subheader
	 *
	 * @var string
	 */
	protected $subheader;

	/**
	 * breadcrumb
	 *
	 * @Todo: Vielleicht kann dies in eine abstrakte Klasse gepackt werden
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
	 * Returns the header
	 *
	 * @return string $header
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Returns the bodytext
	 *
	 * @return string $bodytext
	 */
	public function getBodytext() {
		return $this->bodytext;
	}

	/**
	 * Returns the subheader
	 *
	 * @return string $subheader
	 */
	public function getSubheader() {
		return $this->subheader;
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

}
