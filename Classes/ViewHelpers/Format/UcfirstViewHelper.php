<?php
namespace Sunzinet\SzIndexedSearch\ViewHelpers\Format;

/**
 * Description of the class 'UcfirstViewHelper.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class UcfirstViewHelper
 *
 * @package Sunzinet\ViewHelpers\Format
 */
class UcfirstViewHelper extends AbstractViewHelper {

	/**
	 * @return string The result with first letter uppercase
	 */
	public function render() {
		return ucfirst($this->renderChildren());
	}

}
