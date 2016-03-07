<?php
namespace Sunzinet\SzIndexedSearch\ViewHelpers\Format;

/**
 * Make a string's first character uppercase
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
class UcfirstViewHelper extends AbstractViewHelper
{
    /**
     * Make a string's first character uppercase
     *
     * @return string
     */
    public function render()
    {
        $string = $this->renderChildren();
        if (!is_string($string)) {
            throw new \InvalidArgumentException('Parameter $searchString must be of type string', 1440585046);
        }

        if ($string === '') {
            throw new \InvalidArgumentException('Given String must not be Empty', 1440581637);
        }

        return ucfirst($string);
    }
}
