<?php
namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class News
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class News extends \GeorgRinger\News\Domain\Model\News
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
