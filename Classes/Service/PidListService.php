<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Service;

use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class PidListService
{
    /**
     * @param array $storagePageIds
     * @param array $blockedPageIds
     * @return array
     */
    public function generate(array $storagePageIds, array $blockedPageIds): array
    {
        $allowedPageIds = [];
        $disallowedPageIds = [];

        foreach ($storagePageIds as $storagePageId) {
            $allowedPageIds = array_merge(
                $allowedPageIds,
                $this->extendPidListByChildren((int) $storagePageId)
            );
        }

        foreach ($blockedPageIds as $blockedPageId) {
            $disallowedPageIds = array_merge(
                $disallowedPageIds,
                $this->extendPidListByChildren((int) $blockedPageId)
            );
        }

        return array_diff($allowedPageIds, $disallowedPageIds);
    }

    /**
     * Filter all pids and check if they are allowed for the fegroup
     *
     * @param array $storagePids
     * @return array
     */
    private static function filterNotAllowed(array $storagePids)
    {
        foreach ($storagePids as $pkey => $pid) {
            $page = self::getTsfe()->sys_page->getPage_noCheck($pid);
            if (
                (int) $page['doktype'] === PageRepository::DOKTYPE_DEFAULT
                && count(self::getTsfe()->sys_page->getPage($pid)) === 0
            ) {
                unset($storagePids[$pkey]);
            }
        }

        return array_values($storagePids);
    }

    /**
     * Find all ids from given ids and level
     *
     * @param int $storagePageId
     * @return array
     */
    private function extendPidListByChildren(int $storagePageId): array
    {
        $treeList = GeneralUtility::makeInstance(QueryGenerator::class)->getTreeList(
            $storagePageId,
            6,
            0,
            'hidden=0 AND deleted=0'
        );
        $allStoragePageIds = [$storagePageId, ...GeneralUtility::intExplode(',', $treeList, true)];
        return array_unique(self::filterNotAllowed($allStoragePageIds), SORT_NUMERIC);
    }

    /**
     * @return TypoScriptFrontendController
     */
    private static function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
