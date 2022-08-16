<?php

declare(strict_types=1);

return [
    \Sunzinet\SzQuickfinder\Domain\Model\Page::class => [
        'tableName' => 'pages',
    ],
    \Sunzinet\SzQuickfinder\Domain\Model\PageLanguageOverlay::class => [
        'tableName' => 'pages_language_overlay',
    ],
    \Sunzinet\SzQuickfinder\Domain\Model\News::class => [
        'tableName' => 'tx_news_domain_model_news',
    ],
    \Sunzinet\SzQuickfinder\Domain\Model\File::class => [
        'tableName' => 'sys_file_reference',
    ],
    \Sunzinet\SzQuickfinder\Domain\Model\User::class => [
        'tableName' => 'fe_users',
    ],
    \Sunzinet\SzQuickfinder\Domain\Model\Content::class => [
        'tableName' => 'tt_content',
    ],
];
