<?php
namespace Sunzinet\SzQuickfinder;

use Sunzinet\SzQuickfinder\Settings\TyposcriptSettings;

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
