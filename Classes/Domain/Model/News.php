<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class News extends AbstractSearch
{
    /**
     * @var string
     */
    protected string $title;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
