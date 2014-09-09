<?php
/**
 * Description of the class 'UcfirstViewHelper.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */
class Tx_SzIndexedSearch_ViewHelpers_Format_UcfirstViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @return string The result with first letter uppercase
	 */
	public function render() {
		return ucfirst($this->renderChildren());
	}

}
