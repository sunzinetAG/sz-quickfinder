<?php

defined('TYPO3') || exit;

(static function (): void {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'sz_quickfinder',
        'Configuration/TypoScript',
        'Quickfinder'
    );
})();
