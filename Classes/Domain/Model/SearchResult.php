<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

trait SearchResult
{
    /**
     * @return array
     */
    public function getRootline(): array
    {
        /** @var RootlineUtility $rootline */
        $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $this->getPid());
        return array_reverse($rootline->get());
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return (int) $this->pid;
    }
}
