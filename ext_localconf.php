<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (empty($_EXTKEY)) {
	$_EXTKEY = 'sz_indexed_search';
}
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi99',
	array(
		'Search' => 'autocomplete',
	),
	array(
		'Search' => 'autocomplete',
	)
);

//eID
$TYPO3_CONF_VARS['FE']['eID_include']['tx_szindexedsearch_autocomplete'] = 'EXT:' . $_EXTKEY . '/Classes/Utility/eidDispatcher.php';

