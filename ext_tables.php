<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionKey,
        'Pi1',
        'Quickfinder'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Quickfinder'
    );

    $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ', nav_hide';
};

$boot('sz_quickfinder');
unset($boot);
