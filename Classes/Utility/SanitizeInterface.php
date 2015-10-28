<?php
namespace Sunzinet\SzIndexedSearch\Utility;

/**
 * Description of the class 'SanitizeInterface.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Interface SanitizeInterface
 *
 * @package Sunzinet\SzIndexedSearch\Utility
 */
interface SanitizeInterface {

	/**
	 * sanitize
	 *
	 * @param string $str
	 * @return mixed
	 */
	public function sanitize($str);

	/**
	 * sanitized
	 *
	 * @return bool
	 */
	public function sanitized();

}
