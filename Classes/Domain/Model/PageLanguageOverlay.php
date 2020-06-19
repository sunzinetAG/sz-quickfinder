<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class PageLanguageOverlay
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class PageLanguageOverlay extends AbstractSearch
{
    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * url
     *
     * @var string
     */
    protected $url;

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle;

    /**
     * keywords
     *
     * @var string
     */
    protected $keywords;

    /**
     * author
     *
     * @var string
     */
    protected $author;

    /**
     * breadcrumb
     *
     * @var string
     */
    protected $breadcrumb;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Returns the keywords
     *
     * @return string $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Returns the author
     *
     * @return string $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Returns the breadcrumb
     *
     * @return string $breadcrumb
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * Sets the breadcrumb
     *
     * @param string $breadcrumb
     * @return PageLanguageOverlay
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }
}
