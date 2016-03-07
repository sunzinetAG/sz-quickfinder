<?php
namespace Sunzinet\SzIndexedSearch\Utility;

    /**
     * Description of the class 'SanitizeUtility.php'
     *
     * @author Dennis Römmich <dennis@roemmich.eu>
     * @copyright Copyright belongs to the respective authors
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */

/**
 * Class GeneralUtility
 *
 * @package Sunzinet\SzIndexedSearch\Utility
 */
class SanitizeUtility implements SanitizeInterface
{

    /**
     * isSanitized
     *
     * @var bool $isSanitized
     */
    protected $isSanitized = false;

    /**
     * string
     *
     * @var string $string
     */
    protected $string = '';

    /**
     * __construct
     *
     * @param string $string
     * @return $this
     */
    public function __construct($string)
    {
        $this->string = $string;
        $this->sanitize();
    }

    /**
     * quoteStr
     *
     * @return $this
     */
    public function sanitize()
    {
        $this->string = urldecode($this->string);
        $this->string = $GLOBALS['TYPO3_DB']->escapeStrForLike($this->string, 'pages');
        $this->string = $GLOBALS['TYPO3_DB']->quoteStr($this->string, 'pages');

        $this->isSanitized = true;

        return $this;
    }

    /**
     * isSanitized
     *
     * @return bool
     */
    public function sanitized()
    {
        return $this->isSanitized;
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }

}
