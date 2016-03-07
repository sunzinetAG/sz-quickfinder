<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Indexed Search Autocomplete'
);

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ', nav_hide';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Indexed Search Autocomplete');
