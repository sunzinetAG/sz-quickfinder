<?php
namespace Sunzinet\SzQuickfinder\Utility;

/**
 * Interface SanitizeInterface
 * @package Sunzinet\SzQuickfinder\Utility
 */
interface SanitizeInterface
{
    /**
     * sanitize
     *
     * @return mixed
     */
    public function sanitize();

    /**
     * sanitized
     *
     * @return bool
     */
    public function sanitized();
}
