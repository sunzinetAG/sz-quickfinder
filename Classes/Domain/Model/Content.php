<?php

/**
 * Description of the phpfile 'User.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_SzIndexedSearch_Domain_Model_Content extends Tx_Extbase_DomainObject_AbstractEntity {

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

}

?>