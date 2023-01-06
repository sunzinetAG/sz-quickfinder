<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\SearchResult as SearchResultInterface;
use Sunzinet\SzQuickfinder\TyposcriptSettings;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class AbstractSearch extends AbstractEntity implements SearchResultInterface, Search
{
    use SearchResult;

    /**
     * @var TyposcriptSettings
     */
    protected $settings;

    /**
     * @param TyposcriptSettings $settings
     * @return void
     */
    public function injectSettings(TyposcriptSettings $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return TyposcriptSettings
     */
    public function getSettings(): TyposcriptSettings
    {
        return $this->settings;
    }
}
