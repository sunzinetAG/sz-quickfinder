<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Dennis Römmich <dennis.roemmich@sunzinet.com>, sunzinet AG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Trait SearchResult
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 * Sunzinet\SzIndexedSearch\Domain\Model; */
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
