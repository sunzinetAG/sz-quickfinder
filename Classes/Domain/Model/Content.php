<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class Content
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class Content extends AbstractSearch
{
    /**
     * @var string $header
     */
    protected $header;

    /**
     * @var string $bodytext
     */
    protected $bodytext;

    /**
     * @var string $subheader
     */
    protected $subheader;

    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Returns the bodytext
     *
     * @return string $bodytext
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * Returns the subheader
     *
     * @return string $subheader
     */
    public function getSubheader()
    {
        return $this->subheader;
    }
}
