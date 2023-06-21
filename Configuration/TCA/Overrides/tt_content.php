<?php

defined('TYPO3') || exit;

(static function (): void {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'SzQuickfinder',
        'Pi1',
        'Quickfinder'
    );
})();
