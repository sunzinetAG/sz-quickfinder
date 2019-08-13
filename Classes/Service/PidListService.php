<?php


namespace Sunzinet\SzQuickfinder\Service;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class PidListService
 *
 * @package Sunzinet\SzQuickfinder\Service
 */
class PidListService
{
    /**
     * @var array
     */
    private $storagePids = [];

    /**
     * @var array
     */
    private $blacklistPids = [];

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * PidListService constructor.
     * @param array $storagePids
     * @param array $blacklistPids
     */
    public function __construct(array $storagePids, array $blacklistPids, ObjectManager $objectManager)
    {
        $this->storagePids = $storagePids;
        $this->blacklistPids = $blacklistPids;
        $this->objectManager = $objectManager;
    }

    /**
     * @param array $storagePids contains the whitelist pids
     * @param array $blacklistPids contains the blacklist pids
     *
     * @return array
     */
    public function generate()
    {
        $whitelistPids = [];
        $blacklistPids = [];
        foreach ($this->storagePids as $storagePid) {
            $whitelistPids = array_merge($whitelistPids, $this->extendPidListByChildren($storagePid, 6));
        }

        foreach ($this->blacklistPids as $blacklistPid) {
            $blacklistPids = array_merge($blacklistPids, $this->extendPidListByChildren($blacklistPid, 6));
        }

        return array_diff($whitelistPids, $blacklistPids);
    }

    /**
     * Filter all pids and check if they are allowed for the fegroup
     *
     * @param array $storagePids
     * @return array
     */
    private function filterNotAllowed(array $storagePids)
    {
        $tsfe = $this->getTyposcriptFrontendController();
        foreach ($storagePids as $pkey => $pid) {
            $page = $tsfe->sys_page->getPage_noCheck(4);
            if ((int) $page['doktype'] === \TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT && count($tsfe->sys_page->getPage($pid)) === 0) {
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
    private function extendPidListByChildren($pidList = '', $recursive = 0)
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
     * @return TypoScriptFrontendController
     */
    private function getTyposcriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
