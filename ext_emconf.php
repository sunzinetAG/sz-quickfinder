<?php

$EM_CONF['sz_quickfinder'] = [
    'title' => 'Quickfinder',
    'description' => 'SzQuickfinder - Quickfinder Plugin der sunzinet AG',
    'category' => 'plugin',
    'author' => 'Dennis Römmich',
    'author_email' => 'dennis.roemmich@sunzinet.com',
    'author_company' => 'sunzinet AG',
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
    'version' => '6.0.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5 - 11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => ['Sunzinet\\SzQuickfinder\\' => 'Classes']
    ],
    'autoload-dev' => [
        'psr-4' => ['Sunzinet\\SzQuickfinder\\Tests\\' => 'Tests']
    ]
];
