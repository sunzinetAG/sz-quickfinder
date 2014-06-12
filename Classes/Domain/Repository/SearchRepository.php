<?php

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

/**
 *
 *
 * @package sz_indexed_search
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_SzIndexedSearch_Domain_Repository_SearchRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Type of the Model
	 *
	 * @var object
	 */
	public $type;

	/**
	 * logicalAnd
	 *
	 * @var array
	 */
	protected $logicalAnd = array();

	/**
	 * logicalOr
	 *
	 * @var array
	 */
	protected $logicalOr = array();

	/**
	 * Builds the custom Search
	 *
	 * @param Tx_SzIndexedSearch_Domain_Model_CustomSearch $customSearch
	 * @param array $settings
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function customSearch(Tx_SzIndexedSearch_Domain_Model_CustomSearch $customSearch, array $settings) {

		if($customSearch->getTable() === 'Tx_SzIndexedSearch_Domain_Model_Page' AND $this->createQuery()->getQuerySettings()->getLanguageUid() !== 0) {
			$this->type = 'Tx_SzIndexedSearch_Domain_Model_PageLanguageOverlay';
		} else {
			$this->type = $customSearch->getTable();
		}

		$query = $this->persistenceManager->createQueryForType($this->type);

		$query->getQuerySettings()
				->setRespectStoragePage(FALSE)
				->setRespectSysLanguage(TRUE)
				->setLanguageMode('strict');

		$constraints = array();

		foreach($customSearch->getSearchFields() as $propertyName) {
			$constraints[] = $query->like($propertyName, $this->regSearchExp($customSearch->getSearchString(), $settings));
		}

		$this->getCustomEnableFields($query, $query->getQuerySettings()->getStoragePageIds());

		array_push($this->logicalAnd, $query->logicalOr($constraints));

		$query->matching(
			$query->logicalAnd(
				$this->logicalAnd,
				$query->logicalOr($this->logicalOr)
			)
		);

		$this->logicalAnd = array();
		$this->logicalOr = array();

		$query->setLimit(intval($settings['max_results']));

		$results = $query->execute();

		foreach($results as $result) {
			if($result->changeUidToPid == true) {
				if($customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_Page' || $customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_PageLanguageOverlay' || $customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_File') {
					$result->setBreadcrumb($this->getBreadcrumb($result->getUid(), $query->getQuerySettings()->getLanguageUid(), $settings['breadcrumb_seperator']));
				}
			} else {
				if($customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_Page' || $customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_PageLanguageOverlay' || $customSearch->getTable() == 'Tx_SzIndexedSearch_Domain_Model_File') {
					$result->setBreadcrumb($this->getBreadcrumb($result->getPid(), $query->getQuerySettings()->getLanguageUid(), $settings['breadcrumb_seperator']));
				}
			}
		}

		return $results;
	}

	/**
	 * @param $query \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 * @param array $storagePids
	 */
	protected function getCustomEnableFields($query, $storagePids) {
		if($this->type === 'Tx_SzIndexedSearch_Domain_Model_Page') {
			foreach($storagePids as $storagePid) {
				array_push($this->logicalOr, $query->in('uid', $this->extendPidListByChildren($storagePid, 6)));
			}
			array_push($this->logicalAnd, $query->equals('nav_hide', 0));
			array_push($this->logicalAnd, $query->logicalNot($query->equals('doktype', 254)));
			array_push($this->logicalAnd, $query->logicalNot($query->equals('doktype', 4)));
		} else {
			foreach($storagePids as $storagePid) {
				array_push($this->logicalOr, $query->in('pid', $this->extendPidListByChildren($storagePid, 6)));
			}
		}
	}

	/**
	 * @param $searchString
	 * @param $settings
	 * @return mixed|string
	 */
	protected function regSearchExp($searchString, $settings) {
		$searchString = urldecode($searchString);
		$searchString = $GLOBALS['TYPO3_DB']->escapeStrForLike($searchString, 'pages');
		$searchString = $GLOBALS['TYPO3_DB']->quoteStr($searchString, 'pages');
		if($settings['reg_search_exp']) {
			$searchString = str_replace('|', $searchString, $GLOBALS['TYPO3_DB']->quoteStr($settings['reg_search_exp'], 'pages'));
		} else {
			$searchString = '%' . $searchString . '%';
		}

		return $searchString;
	}

	/**
	 * Find all ids from given ids and level
	 *
	 * @param string $pidList comma separated list of ids
	 * @param integer $recursive recursive levels
	 * @return string comma separated list of ids
	 */
	protected function extendPidListByChildren($pidList = '', $recursive = 0) {
		$recursive = (int)$recursive;
		if ($recursive <= 0) {
			return $pidList;
		}

		/** @var $queryGenerator t3lib_queryGenerator */
		$queryGenerator = $this->objectManager->create('t3lib_queryGenerator');
		$recursiveStoragePids = $pidList;
		$storagePids = t3lib_div::intExplode(',', $pidList);
		foreach ($storagePids as $startPid) {
			$pids = $queryGenerator->getTreeList($startPid, $recursive, 0, 1);
			if (strlen($pids) > 0) {
				$recursiveStoragePids .= ',' . $pids;
			}
		}

		$return = explode(',', $recursiveStoragePids);

		return $return;
	}

	/**
	 * Builds breadcrumbs
	 *
	 * @param int $pid
	 * @return string The breadcrumbs
	 */

	/**
	 * Builds breadcrumbs
	 *
	 * @param int $pid Page Id
	 * @param int $sys_language_uid
	 * @param string $seperator
	 * @return string The Breadcrumb
	 */
	protected function getBreadcrumb($pid, $sys_language_uid = 0, $seperator = '>') {
		/** @var $pageSelect t3lib_pageSelect */
		$pageSelect = $this->objectManager->create('t3lib_pageSelect');
		$pageSelect->init(TRUE);

		$result = '';
		$i = 0;
		foreach(array_reverse($pageSelect->getRootLine($pid)) as $breadcrumb) {
			if($sys_language_uid != 0) {
				$page = $pageSelect->getPageOverlay($breadcrumb['uid'], $sys_language_uid);
			} else {
				$page = $pageSelect->getPage($breadcrumb['uid'], $sys_language_uid);
			}
			if(!$page) {
				$page = $pageSelect->getPage($breadcrumb['uid'], $sys_language_uid);
			}
			$pageTitle = $page['tx_realurl_pathsegment'] ? ucfirst($page['tx_realurl_pathsegment']) : ucfirst($page['title']);
			if(!$page['nav_hide'] AND $page['tx_realurl_exclude'] != '1') {
				if($i > 0) {
					$result .= ' ' . $seperator . ' ';
				}
				$result .= $pageTitle;
				$i++;
			}
		}

		return $result;
	}

}
?>