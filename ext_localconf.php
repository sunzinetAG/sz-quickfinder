<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$boot = function ($extensionKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sunzinet.' . $extensionKey,
        'Pi1',
        ['Search' => 'index, search, autocomplete'],
        // non-cacheable actions
        ['Search' => 'autocomplete']
    );
};

$boot($_EXTKEY);
unset($boot);
