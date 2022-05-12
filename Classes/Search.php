<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder;

/**
 * Must be implemented by custom search classes together with SearchResult interface.
 * Alternatively custom search class can extend AbstractSearch model.
 */
interface Search
{
    /**
     * @param TyposcriptSettings $settings
     * @return void
     */
    public function injectSettings(TyposcriptSettings $settings): void;

    /**
     * @return TyposcriptSettings
     */
    public function getSettings(): TyposcriptSettings;
}
