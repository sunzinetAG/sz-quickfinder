<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder;

/**
 * Must be implemented by custom search classes together with Search interface.
 * Alternatively custom search class can extend AbstractSearch model.
 */
interface SearchResult
{
    /**
     * @return array
     */
    public function getRootline(): array;

    /**
     * @return int
     */
    public function getPid(): int;
}
