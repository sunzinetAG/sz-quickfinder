<?php
namespace Sunzinet\SzIndexedSearch\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dennis Römmich <dennis.roemmich@sunzinet.com>, sunzinet AG
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
use Sunzinet\SzIndexedSearch\Domain\Model\File;
use Sunzinet\SzIndexedSearch\Domain\Model\Page;
use Sunzinet\SzIndexedSearch\Domain\Model\PageLanguageOverlay;
use Sunzinet\SzIndexedSearch\SearchInterface;
use Sunzinet\SzIndexedSearch\Settings\TyposcriptSettingsInterface;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Class SearchRepository
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Repository
 */
class SearchRepository extends \TYPO3\CMS\Extbase\Persistence\Repository implements SearchInterface
{
    /**
     * Type of the Model
     *
     * @var string
     */
    public $className;

    /**
     * logicalAnd
     *
     * @var array
     */
    protected $logicalAnd = [];

    /**
     * logicalOr
     *
     * @var array
     */
    protected $logicalOr = [];

    /**
     * constraints
     *
     * @var array
     */
    protected $constraints = [];

    /**
     * @var Query $query
     */
    protected $query;

    /**
     * TypoScript settings
     *
     * @var TyposcriptSettingsInterface $settings
     */
    protected $settings;

    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * Sets the type of the Model
     *
     * @param string $className
     * @return void
     */
    protected function setClassName($className)
    {
        if ($className === Page::class and intval(GeneralUtility::_GP('L')) !== 0) {
            $this->className = PageLanguageOverlay::class;
        } else {
            $this->className = $className;
        }
    }

    /**
     * setQuerySettings
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @return void
     */
    protected function setQuerySettings()
    {
        $defaultOrdering = QueryInterface::ORDER_ASCENDING;
        if ($this->settings->getAscending() === false) {
            $defaultOrdering = QueryInterface::ORDER_DESCENDING;
        }
        $this->query->setOrderings([$this->settings->getOrderBy() => $defaultOrdering]);
        $this->query->getQuerySettings();

        // @Todo: Language not working correctly yet
        $this->query->getQuerySettings()
            ->setLanguageUid(intval(GeneralUtility::_GP('L')))
            ->setRespectStoragePage(false)
            ->setRespectSysLanguage(true);
    }

    /**
     * prepareCustomSearch
     *
     * @param TyposcriptSettingsInterface $settings
     * @return void
     */
    public function injectSettings(TyposcriptSettingsInterface $settings)
    {
        $this->settings = $settings;
        $this->setClassName($this->settings->getClass());
        $this->query = $this->persistenceManager->createQueryForType($this->className);

        $this->setQuerySettings();
        $this->setSearchFields();
        $this->setCustomEnableFields($this->query->getQuerySettings()->getStoragePageIds());

        $this->query->matching(
            $this->query->logicalAnd(
                $this->query->logicalAnd($this->logicalAnd),
                $this->query->logicalOr($this->logicalOr)
            )
        );

        $this->query->setLimit($settings->getMaxResults());
    }

    /**
     * executeCustomSearch
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function executeCustomSearch()
    {
        $results = $this->query->execute();

        return $results;
    }

    /**
     * Fills logicalAnd and logicalOr for the Query
     *
     * @param array $storagePids
     * @return void
     */
    protected function setCustomEnableFields($storagePids)
    {
        switch ($this->className) {
            case Page::class:
                if ($this->settings->getIncludeNavHiddenPages() === false) {
                    array_push(
                        $this->logicalAnd,
                        $this->query->equals('nav_hide', $this->settings->getIncludeNavHiddenPages())
                    );
                }
                array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 254)));
                array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 4)));
                break;
            case File::class:
                array_push($this->logicalAnd, $this->query->in('fieldname', $this->settings->getAllowedFieldnames()));
                break;
            default:
        }

        foreach ($storagePids as $storagePid) {
            array_push($this->logicalOr, $this->query->in('pid', $this->extendPidListByChildren($storagePid, 6)));
        }

        array_push($this->logicalAnd, $this->query->logicalOr($this->constraints));
    }

    /**
     * Find all ids from given ids and level
     *
     * @param string $pidList comma separated list of ids
     * @param integer $recursive recursive levels
     * @return string comma separated list of ids
     */
    protected function extendPidListByChildren($pidList = '', $recursive = 0)
    {
        $recursive = (int)$recursive;
        if ($recursive <= 0) {
            return $pidList;
        }

        /** @var $queryGenerator QueryGenerator */
        $queryGenerator = $this->objectManager->get(QueryGenerator::class);
        $recursiveStoragePids = $pidList;
        $storagePids = GeneralUtility::intExplode(',', $pidList);
        foreach ($storagePids as $startPid) {
            $pids = $queryGenerator->getTreeList($startPid, $recursive, 0, 'hidden=0 AND deleted=0');
            if (strlen($pids) > 0) {
                $recursiveStoragePids .= ',' . $pids;
            }
        }

        $return = explode(',', $recursiveStoragePids);

        return $return;
    }

    /**
     * setSearchFields
     *
     * @throws \TYPO3\CMS\Extbase\Security\Exception
     * @return void
     */
    private function setSearchFields()
    {
        if (!($this->settings->getSearchString()->sanitized())) {
            throw new \TYPO3\CMS\Extbase\Security\Exception(
                'SearchString must be sanitized before passing to the query!!',
                1456218496
            );
        }

        $searchString = $this->resolveSearchstring($this->settings->getSearchString());

        foreach ($this->settings->getSearchFields() as $propertyName) {
            $this->constraints[] = $this->query->like(
                $propertyName,
                $searchString
            );
        }
    }

    /**
     * resolveSearchstring
     *
     * @param string $searchString
     * @return string
     */
    protected function resolveSearchstring($searchString)
    {
        return str_replace('|', $searchString, $this->settings->getRegEx());
    }

    /**
     * destroy all properties
     *
     * @return void
     */
    public function reset()
    {
        $this->query = null;
        $this->settings = null;
        $this->logicalAnd = [];
        $this->logicalOr = [];
        $this->constraints = [];
    }
}
