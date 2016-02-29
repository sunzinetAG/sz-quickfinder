<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionKey,
        'Pi1',
        'Indexed Search Autocomplete'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript',
        'Indexed Search Autocomplete');
};

$boot($_EXTKEY);
unset($boot);
