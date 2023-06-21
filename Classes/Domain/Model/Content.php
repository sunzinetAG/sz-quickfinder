<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class Content extends AbstractSearch
{
    /**
     * @var string
     */
    protected string $header = '';

    /**
     * @var string
     */
    protected string $bodytext = '';

    /**
     * @var string
     */
    protected string $subheader = '';

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getBodytext(): string
    {
        return $this->bodytext;
    }

    /**
     * @return string
     */
    public function getSubheader(): string
    {
        return $this->subheader;
    }
}
