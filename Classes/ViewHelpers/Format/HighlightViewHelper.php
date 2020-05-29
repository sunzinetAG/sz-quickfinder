<?php
namespace Sunzinet\SzQuickfinder\ViewHelpers\Format;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class HighlightViewHelper
 * @package Sunzinet\SzQuickfinder\ViewHelpers\Format
 */
class HighlightViewHelper extends AbstractViewHelper
{
    /**
     * searchstring
     *
     * @var string $searchstring
     */
    protected $searchString = '';

    /**
     * Sets the SearchString
     *
     * @return void
     */
    public function initialize()
    {
        $searchStringArr = GeneralUtility::_GP('tx_szquickfinder_pi1');
        $this->setSearchString(urldecode($searchStringArr['searchString']));
    }

    /**
     * The result with highlighted String
     *
     * @return string
     */
    public function render()
    {
        $return = htmlspecialchars_decode($this->renderChildren());
        $occurrences = substr_count(strtolower($return), strtolower($this->searchString));

        $match = [];

        for ($i = 0; $i < $occurrences; $i++) {
            $match[$i] = stripos($return, $this->getSearchString(), $i);
            $match[$i] = substr($return, $match[$i], strlen($this->getSearchString()));
            $return = str_replace($match[$i], '[#]' . $match[$i] . '[@]', $return);
        }

        $return = str_replace('[#]', '<strong>', $return);
        $return = str_replace('[@]', '</strong>', $return);

        return $return;
    }

    /**
     * getSearchstring
     *
     * @return string
     */
    protected function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * setSearchString
     *
     * @param string $searchString
     * @return void
     */
    protected function setSearchString($searchString = '')
    {
        if (!is_string($searchString)) {
            throw new \InvalidArgumentException('Parameter $searchString must be of type string', 1440585046);
        }

        if ($searchString === '') {
            throw new \InvalidArgumentException('Given String must not be Empty', 1440581637);
        }
        $this->searchString = $searchString;
    }
}
