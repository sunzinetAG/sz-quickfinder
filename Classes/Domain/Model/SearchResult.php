<?php
namespace Sunzinet\SzQuickfinder\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Trait SearchResult
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
trait SearchResult
{
    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * getRootline
     *
     * @return array
     */
    public function getRootline()
    {
        /** @var $pageSelect PageRepository */
        $pageSelect = $this->objectManager->get(PageRepository::class);
        $pageSelect->init(false);

        /** @var RootlineUtility $rootline */
        $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $this->getPid());

        return array_reverse($rootline->get());
    }

    /**
     * getPageId
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }
}
