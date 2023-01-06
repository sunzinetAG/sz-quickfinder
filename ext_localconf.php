<?php

defined('TYPO3_MODE') || exit;

// Configure plugins
(static function (): void {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Pi1',
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'index, search, autocomplete']
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Index',
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'index'],
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'index']
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Search',
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'search'],
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'search']
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Autocomplete',
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'autocomplete'],
        [\Sunzinet\SzQuickfinder\Controller\SearchController::class => 'autocomplete']
    );
})();

// Setting ext config
(static function (): void {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository'] =
        \Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository::class;
})();

// Adjust global TYPO3 config variables
(static function (): void {
    // Exclude searchParameter from cHash, due to problems with pageNotFoundOnCHashError=1
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_szquickfinder_pi1[searchString]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_szquickfinder_autocomplete[searchString]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ', nav_hide';
})();
