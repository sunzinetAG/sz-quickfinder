<?php

namespace Sunzinet\SzQuickfinder\Tests\Stub;

/**
 * Class AbstractSearch
 *
 * @package Sunzinet\SzQuickfinder\Tests\Stub
 */
class AbstractSearch extends \Sunzinet\SzQuickfinder\Domain\Model\AbstractSearch
{
    public function __construct()
    {
        $this->pid = 123;
    }
}
