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
    private string $searchString = '';

    public function initializeArguments(): void
    {
        $this->registerArgument('searchString', 'string', 'String to highlight', false, '');
    }

    /**
     * @return void
     */
    public function initialize(): void
    {
        $searchStringArr = GeneralUtility::_GP('tx_szquickfinder_autocomplete');
        if (GeneralUtility::_GP('tx_szquickfinder_pi1') !== null) {
            $searchStringArr = GeneralUtility::_GP('tx_szquickfinder_pi1');
            trigger_error(
                'Param "tx_szquickfinder_pi1" is deprecated since version 6.0.0, will be removed in version 7.0.0',
                E_USER_DEPRECATED
            );
        }

        $this->searchString = $this->arguments['searchString'] ?: urldecode($searchStringArr['searchString']) ?? '';
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
