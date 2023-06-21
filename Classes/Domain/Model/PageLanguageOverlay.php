<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class PageLanguageOverlay extends AbstractSearch
{
    /**
     * @var string
     */
    protected string $title = '';

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var string
     */
    protected string $subtitle = '';

    /**
     * @var string
     */
    protected string $keywords = '';

    /**
     * @var string
     */
    protected string $author = '';

    /**
     * @var string
     */
    protected string $breadcrumb = '';

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
