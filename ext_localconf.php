<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$boot = function ($extensionKey) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'Sunzinet.' . $extensionKey,
		'Pi1',
		array(
			'Search' => 'index, search, autocomplete',
		),
		// non-cacheable actions
		array(
			'Search' => 'autocomplete',
		)
	);


};

$boot($_EXTKEY);
unset($boot);

\Sunzinet\SzIndexedSearch\Utility\AjaxDispatcher::activateAjaxDispatcher();
