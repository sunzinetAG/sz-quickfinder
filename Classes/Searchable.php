<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder;

/**
 * Interface Searchable
 * @package Sunzinet\SzQuickfinder
 */
interface Searchable
{
    /**
     * executeCustomSearch
     *
     * @return mixed
     */
    public function executeCustomSearch();

    /**
     * @param Search $class
     * @return void
     */
    public function initClass(Search $class);

    /**
     * reset
     *
     * @return void
     */
    public function reset();
}
