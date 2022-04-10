<?php

defined('TYPO3_MODE') || exit;

(static function (): void {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'sz_quickfinder',
        'Configuration/TypoScript',
        'Quickfinder'
    );
})();
