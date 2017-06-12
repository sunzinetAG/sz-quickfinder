<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sunzinet.' . $extensionKey,
        'Pi1',
        ['Search' => 'index, search, autocomplete']
    );

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository'] =
        \Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository::class;
};

$boot('sz_quickfinder');
unset($boot);
