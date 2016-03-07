<?php
namespace Sunzinet\SzIndexedSearch\ViewHelpers\Format;

/**
 * Description of the class 'HighlightViewHelper.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class FilterViewHelper
 *
 * @package Sunzinet\ViewHelpers\Format
 */
class FilterViewHelper extends AbstractViewHelper
{
    /**
     * returns only the word, which includes the given searchstring
     *
     * @return string
     */
    public function render()
    {
        $searchStringArr = GeneralUtility::_GP('tx_szindexedsearch_pi1');
        $searchString = urldecode($searchStringArr['searchString']);

        $return = htmlspecialchars_decode($this->renderChildren());
        $occurrences = substr_count(strtolower($return), strtolower($searchString));

        $match = array();

        for ($i = 0; $i < $occurrences; $i++) {
            $match[$i] = stripos($return, $searchString, $i);
            $match[$i] = substr($return, $match[$i], strlen($searchString));

            $returnArr = explode(',', $return);

            $return = array_values(preg_grep('/' . $match[$i] . '/', $returnArr));
            $return = trim($return[0]);
        }

        return $return;
    }
}
