<?php

namespace Sunzinet\SzQuickfinder\Domain\Repository;

use Sunzinet\SzQuickfinder\Domain\Model\File;
use Sunzinet\SzQuickfinder\Domain\Model\Page;
use Sunzinet\SzQuickfinder\Domain\Model\PageLanguageOverlay;
use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\Searchable;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

/**
 * Class SearchRepository
 * @package Sunzinet\SzQuickfinder\Domain\Repository
 */
class SearchRepository extends \TYPO3\CMS\Extbase\Persistence\Repository implements Searchable
{
    /**
     * Type of the Model
     *
     * @var string
     */
    public $className;

    /**
     * @var Search $class
     */
    protected $class;

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
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * Sets the type of the Model
     *
     * @Todo: Add Unittest
     * @param Search $class
     * @return void
     */
    public function initClass(Search $class)
    {
        $this->class = $class;
        if ($class->getSettings()->getClass() === Page::class and intval(GeneralUtility::_GP('L')) !== 0) {
            $this->className = PageLanguageOverlay::class;
        } else {
            $this->className = $class->getSettings()->getClass();
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
        if ($this->class->getSettings()->getAscending() === false) {
            $defaultOrdering = QueryInterface::ORDER_DESCENDING;
        }
        $this->query->setOrderings([$this->class->getSettings()->getOrderBy() => $defaultOrdering]);
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
     * @return void
     */
    public function initSettings()
    {
        $this->query = $this->persistenceManager->createQueryForType($this->className);

        $this->setQuerySettings();
        $this->setSearchFields();
        $this->setCustomEnableFields($this->query->getQuerySettings()->getStoragePageIds());

        $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
        $signalSlotDispatcher->dispatch(__CLASS__, 'afterInitSettings', [&$this->logicalAnd, $this->className, $this->query]);

        $this->query->matching(
            $this->query->logicalAnd(
                $this->query->logicalAnd($this->logicalAnd),
                $this->query->logicalOr($this->logicalOr)
            )
        );

        $this->query->setLimit($this->class->getSettings()->getMaxResults());
    }

    /**
     * executeCustomSearch
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function executeCustomSearch()
    {
        $this->initSettings();
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
                if ($this->class->getSettings()->getIncludeNavHiddenPages() === false) {
                    array_push(
                        $this->logicalAnd,
                        $this->query->equals('nav_hide', $this->class->getSettings()->getIncludeNavHiddenPages())
                    );
                }
                array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 254)));
                array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 4)));
                break;
            case File::class:
                array_push(
                    $this->logicalAnd,
                    $this->query->in('fieldname', $this->class->getSettings()->getAllowedFieldnames())
                );
                break;
            default:
        }

        foreach ($storagePids as $storagePid) {
            $pids = $this->extendPidListByChildren($storagePid, 6);
            if (!empty($pids)) {
                array_push($this->logicalOr, $this->query->in('pid', $pids));
            }
        }

        array_push($this->logicalAnd, $this->query->logicalOr($this->constraints));
    }

    /**
     * Filter all pids and check if they are allowed for the fegroup
     *
     * @param array $storagePids
     * @return array
     */
    protected function filterNotAllowed(array $storagePids)
    {
        foreach ($storagePids as $pkey => $pid) {
            $page = $GLOBALS['TSFE']->sys_page->getPage_noCheck(4);
            if ((int) $page['doktype'] === \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT && count($GLOBALS['TSFE']->sys_page->getPage($pid)) === 0) {
                unset($storagePids[$pkey]);
            }
        }

        return array_values($storagePids);
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

        return $this->filterNotAllowed($return);
    }

    /**
     * setSearchFields
     *
     * @throws \TYPO3\CMS\Extbase\Security\Exception
     * @return void
     */
    private function setSearchFields()
    {
        if (!($this->class->getSettings()->getSearchString()->sanitized())) {
            throw new \TYPO3\CMS\Extbase\Security\Exception(
                'SearchString must be sanitized before passing to the query!!',
                1456218496
            );
        }

        $searchString = $this->resolveSearchstring($this->class->getSettings()->getSearchString());

        foreach ($this->class->getSettings()->getSearchFields() as $propertyName) {
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
        return str_replace('|', $searchString, $this->class->getSettings()->getRegEx());
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
