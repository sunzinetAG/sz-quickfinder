<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

use Sunzinet\SzQuickfinder\TyposcriptSettings;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

trait QuickfinderModelTrait
{
    /**
     * @var TyposcriptSettings
     */
    protected $settings;

    /**
     * @var int
     */
    protected $pid = 0;

    /**
     * @param TyposcriptSettings $settings
     * @return void
     */
    public function injectSettings(TyposcriptSettings $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return TyposcriptSettings
     */
    public function getSettings(): TyposcriptSettings
    {
        return $this->settings;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return (int) $this->pid;
    }

    /**
     * @return array
     */
    public function getRootline(): array
    {
        /** @var RootlineUtility $rootline */
        $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $this->getPid());
        return array_reverse($rootline->get());
    }
}
