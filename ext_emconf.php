<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Quickfinder',
    'description' => 'SzQuickfinder - Quickfinder Plugin from SUNZINET GmbH',
    'category' => 'plugin',
    'author' => 'Dennis Römmich',
    'author_email' => 'info@sunzinet.com',
    'author_company' => 'SUNZINET GmbH',
    'state' => 'stable',
    'version' => '6.2.0',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.2.99',
            'typo3' => '11.5.0-11.5.99',
            'filemetadata' => '*',
        ],
    ],
];
