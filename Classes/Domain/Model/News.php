<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class News
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class News extends AbstractSearch
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     *
     */
    public function getTitle()
    {
        return $this->title;
    }
}
