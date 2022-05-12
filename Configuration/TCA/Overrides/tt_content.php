<?php

defined('TYPO3_MODE') || exit;

(static function (): void {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'SzQuickfinder',
        'Pi1',
        'Quickfinder'
    );
})();
