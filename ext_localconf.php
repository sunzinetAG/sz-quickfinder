<?php

use Sunzinet\SzQuickfinder\Controller\SearchController;
use Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || exit;

// Configure plugins
(static function (): void {
    ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Pi1',
        [SearchController::class => 'index, search, autocomplete']
    );
    ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Index',
        [SearchController::class => 'index'],
        [SearchController::class => 'index']
    );
    ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Search',
        [SearchController::class => 'search'],
        [SearchController::class => 'search']
    );
    ExtensionUtility::configurePlugin(
        'SzQuickfinder',
        'Autocomplete',
        [SearchController::class => 'autocomplete'],
        [SearchController::class => 'autocomplete']
    );
})();

// Setting ext config
(static function (): void {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository'] =
        SearchRepository::class;
})();

// Adjust global TYPO3 config variables
(static function (): void {
    // Exclude searchParameter from cHash, due to problems with pageNotFoundOnCHashError=1
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_szquickfinder_pi1[searchString]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'tx_szquickfinder_autocomplete[searchString]';
    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ', nav_hide';
})();
