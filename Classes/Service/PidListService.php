<?php

declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Service;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryHelper;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class PidListService
{
    /**
     * @param iterable $storagePageIds
     * @param iterable $blockedPageIds
     * @return array
     */
    public function generate(iterable $storagePageIds, iterable $blockedPageIds): array
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
        // @extensionScannerIgnoreLine
        $pageRepository = self::getTsfe()->sys_page;

        foreach ($storagePids as $pkey => $pid) {
            $page = $pageRepository->getPage_noCheck($pid);
            $dokType = (int) ($page['doktype'] ?? 0);
            if (
                $dokType === PageRepository::DOKTYPE_DEFAULT
                && count($pageRepository->getPage($pid)) === 0
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
        $treeList = $this->getTreeList(
            $storagePageId,
            6,
            0,
            'hidden=0 AND deleted=0'
        );
        $allStoragePageIds = [$storagePageId, ...GeneralUtility::intExplode(',', $treeList, true)];
        return array_unique(self::filterNotAllowed($allStoragePageIds), SORT_NUMERIC);
    }

    /**
     * Recursively fetch all descendants of a given page
     *
     * @param int $id uid of the page
     * @param int $depth
     * @param int $begin
     * @param string $permClause
     * @throws DBALException
     * @throws Exception
     * @return string comma separated list of descendant pages
     */
    public function getTreeList($id, $depth, $begin = 0, $permClause = '')
    {
        $depth = (int)$depth;
        $begin = (int)$begin;
        $id = (int)$id;
        if ($id < 0) {
            $id = abs($id);
        }
        if ($begin === 0) {
            $theList = $id;
        } else {
            $theList = '';
        }
        if ($id && $depth > 0) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
            $queryBuilder->select('uid')
                ->from('pages')
                ->where(
                    $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('sys_language_uid', 0)
                )
                ->orderBy('uid');
            if ($permClause !== '') {
                $queryBuilder->andWhere(QueryHelper::stripLogicalOperatorPrefix($permClause));
            }
            $statement = $queryBuilder->execute();
            while ($row = $statement->fetchAssociative()) {
                if ($begin <= 0) {
                    $theList .= ',' . $row['uid'];
                }
                if ($depth > 1) {
                    $theSubList = $this->getTreeList($row['uid'], $depth - 1, $begin - 1, $permClause);
                    if (!empty($theList) && !empty($theSubList) && ($theSubList[0] !== ',')) {
                        $theList .= ',';
                    }
                    $theList .= $theSubList;
                }
            }
        }
        return $theList;
    }

    /**
     * @return TypoScriptFrontendController
     */
    private static function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TYPO3_REQUEST']->getAttribute('frontend.controller');
    }
}
