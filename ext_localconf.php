<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
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

?>