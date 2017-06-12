<?php
namespace Sunzinet\SzQuickfinder;

/**
 * Interface TyposcriptSettings
 * @package Sunzinet\SzQuickfinder
 */
interface TyposcriptSettings
{
    /**
     * getClass
     *
     * @return string
     */
    public function getClass();

    /**
     * getRegEx
     *
     * @return string
     */
    public function getRegEx();

    /**
     * getMaxResults
     *
     * @return int
     */
    public function getMaxResults();

    /**
     * getIncludeNavHiddenPages
     *
     * @return int
     */
    public function getIncludeNavHiddenPages();

    /**
     * getSearchfields
     *
     * @return string
     */
    public function getSearchfields();

    /**
     * getAllowedFieldnames
     *
     * @return string
     */
    public function getAllowedFieldnames();

    /**
     * getSearchString
     *
     * @return string
     */
    public function getSearchString();

    /**
     * getOrderBy
     *
     * @return string
     */
    public function getOrderBy();

    /**
     * getScript
     *
     * @return string
     */
    public function getScript();

    /**
     * getParams
     *
     * @return array
     */
    public function getParams();

    /**
     * @return boolean
     */
    public function getAscending();

    /**
     * setProperty
     *
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    public function setProperty($propertyName, $value);
}
