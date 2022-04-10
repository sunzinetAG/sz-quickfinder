<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Quickfinder',
    'description' => 'SzQuickfinder - Quickfinder Plugin from SUNZINET GmbH',
    'category' => 'plugin',
    'author' => 'Dennis Römmich',
    'author_email' => 'info@sunzinet.com',
    'author_company' => 'SUNZINET GmbH',
    'state' => 'stable',
    'uploadfolder' => false,
    'version' => '6.0.0-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-7.4.99',
            'typo3' => '10.4.0-11.5.99',
            'filemetadata' => '*',
        ],
    ],
];
