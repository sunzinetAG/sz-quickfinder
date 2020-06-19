<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

/**
 * Trait SearchResult
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
trait SearchResult
{
    /**
     * getRootline
     *
     * @return array
     */
    public function getRootline()
    {
        /** @var RootlineUtility $rootline */
        $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $this->getPid());

        return array_reverse($rootline->get());
    }

    /**
     * getPageId
     *
     * @return int
     */
    public function getPid(): ?int
    {
        return $this->pid;
    }
}
