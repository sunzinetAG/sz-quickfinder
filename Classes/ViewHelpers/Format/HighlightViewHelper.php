<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\ViewHelpers\Format;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class HighlightViewHelper extends AbstractViewHelper
{
    /**
     * @var string
     */
    private $searchString = '';

    public function initializeArguments(): void
    {
        $this->registerArgument('searchString', 'string', 'String to highlight', false);
    }

    /**
     * @return void
     */
    public function initialize(): void
    {
        $searchStringArr = GeneralUtility::_GP('tx_szquickfinder_autocomplete');
        $this->searchString = $this->arguments['searchString'] ??
            (isset($searchStringArr['searchString']) ? urldecode($searchStringArr['searchString']) : '');
    }

    /**
     * The result with highlighted string
     *
     * @return string
     */
    public function render(): string
    {
        $return = htmlspecialchars_decode($this->renderChildren());
        $occurrences = substr_count(strtolower($return), strtolower($this->searchString));

        $match = [];
        for ($i = 0; $i < $occurrences; $i++) {
            $match[$i] = stripos($return, $this->searchString, $i);
            $match[$i] = substr($return, $match[$i], strlen($this->searchString));
            $return = str_replace($match[$i], '[#]' . $match[$i] . '[@]', $return);
        }

        return str_replace(['[#]', '[@]'], ['<strong>', '</strong>'], $return);
    }
}
