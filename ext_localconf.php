<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Search' => 'index, search, autocomplete',

	),
	// non-cacheable actions
	array(
		'Search' => 'autocomplete',

	)
);
