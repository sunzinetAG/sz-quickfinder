<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class Page extends AbstractSearch
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $subtitle = '';

    /**
     * @var string
     */
    protected $keywords = '';

    /**
     * @var string
     */
    protected $author = '';

    /**
     * @var string
     */
    protected $breadcrumb = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getBreadcrumb(): string
    {
        return $this->breadcrumb;
    }

    /**
     * @param string $breadcrumb
     * @return self
     */
    public function setBreadcrumb(string $breadcrumb): self
    {
        $this->breadcrumb = $breadcrumb;
        return $this;
    }
}
