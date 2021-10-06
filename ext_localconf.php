<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sunzinet.' . $extensionKey,
        'Pi1',
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'index, search, autocomplete']
    );

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository'] =
        \Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository::class;

    // Exclude searchParameter from cHash, due to problems with pageNotFoundOnCHashError=1
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_szquickfinder_pi1[searchString]';
};

$boot('sz_quickfinder');
unset($boot);
