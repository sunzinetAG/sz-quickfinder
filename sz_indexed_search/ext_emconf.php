<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Indexed Search Extend',
	'description' => 'Adds autocomplete to indexed search',
	'category' => 'plugin',
	'author' => 'Robin Rossow',
	'author_email' => 'rr@sunzinet.com',
	'author_company' => 'Sunzinet AG',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
