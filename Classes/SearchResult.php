<?php
namespace Sunzinet\SzQuickfinder;

/**
 * Interface SearchResult
 * @package Sunzinet\SzQuickfinder
 */
interface SearchResult
{
    /**
     * getRootline
     *
     * @return array
     */
    public function getRootline();

    /**
     * getPageId
     *
     * @return int
     */
    public function getPid();
}
