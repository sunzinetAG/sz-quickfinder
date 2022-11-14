<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Suggestion extends AbstractEntity
{
    public const TABLE = 'tx_szquickfinder_domain_model_suggestion';

    /**
     * @var string
     */
    protected string $term = '';

    /**
     * @var string
     */
    protected string $target = '';

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @param string $term
     * @return void
     */
    public function setTerm(string $term): void
    {
        $this->term = $term;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return void
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }
}
