<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\SearchResult as SearchResultInterface;
use Sunzinet\SzQuickfinder\TyposcriptSettings;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class CustomSearch
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
abstract class AbstractSearch extends AbstractEntity implements SearchResultInterface, Search
{
    use SearchResult;

    /**
     * @var TyposcriptSettings $settings
     */
    protected $settings;

    /**
     * @param TyposcriptSettings $settings
     */
    public function injectSettings(TyposcriptSettings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return TyposcriptSettings
     */
    public function getSettings()
    {
        return $this->settings;
    }
}
