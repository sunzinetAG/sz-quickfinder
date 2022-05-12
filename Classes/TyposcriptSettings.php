<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder;

interface TyposcriptSettings
{
    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getRegEx(): string;

    /**
     * @return int
     */
    public function getMaxResults(): int;

    /**
     * @return bool
     */
    public function getIncludeNavHiddenPages(): bool;

    /**
     * @return iterable
     */
    public function getSearchfields(): iterable;

    /**
     * @return array
     */
    public function getAllowedFieldnames(): array;

    /**
     * @return string
     */
    public function getSearchString(): string;

    /**
     * @return string
     */
    public function getOrderBy(): string;

    /**
     * @return string
     */
    public function getScript(): string;

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @return array
     */
    public function getBlacklistPid(): array;

    /**
     * @return bool
     */
    public function getAscending(): bool;

    /**
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    public function setProperty(string $propertyName, $value): void;
}
