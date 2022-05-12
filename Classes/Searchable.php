<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder;

/**
 * Must be implemented by repositories defined via
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder'][$customSearch['class']]['repository'].
 */
interface Searchable
{
    /**
     * @return mixed
     */
    public function executeCustomSearch();

    /**
     * @param Search $class
     * @return void
     */
    public function initClass(Search $class): void;

    /**
     * @return void
     */
    public function reset(): void;
}
