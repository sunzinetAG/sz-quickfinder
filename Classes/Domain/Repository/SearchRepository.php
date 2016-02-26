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

/**
 * Search Repository for sz_indexed_search
 *
 * Class SearchRepository
 *
 * @package sz_indexed_search
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */

use Sunzinet\SzIndexedSearch\Domain\Model\CustomSearch;
use Sunzinet\SzIndexedSearch\Domain\Model\File;
use Sunzinet\SzIndexedSearch\Domain\Model\Page;
use Sunzinet\SzIndexedSearch\Domain\Model\PageLanguageOverlay;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Class SearchRepository
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Repository
 */
class SearchRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

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
	 * constraints
	 *
	 * @var array
	 */
	protected $constraints = array();

	/**
	 * @var Query
	 */
	protected $query;

	/**
	 * TypoScript settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Enable Breadcrumbs for given Types
	 *
	 * @var array
	 */
	protected $showBreadcrumbInSeachresult = array(
		Page::class,
		PageLanguageOverlay::class,
		File::class
	);


	/**
	 * @var int $sysLanguageUid
	 */
	protected $sysLanguageUid;

	/**
	 * @var int $maxResults
	 */
	protected $maxResults = FALSE;


	/**
	 * Builds the custom Search
	 *
	 * @param CustomSearch $customSearch
	 * @param array $settings
	 * @return array|QueryResult
	 */
	public function customSearch(CustomSearch $customSearch, array $settings) {
		$this->sysLanguageUid = $GLOBALS['TSFE']->sys_language_uid;
		$this->settings = $settings;
		$this->setType($customSearch->getTable());
		$this->maxResults = $customSearch->getMaxResults();
		$this->query = $this->persistenceManager->createQueryForType($this->type);
		$this->setQuerySettings();
		$this->constraints = array();

		foreach ($customSearch->getSearchFields() as $propertyName) {
			$this->constraints[] = $this->query->like(
				$propertyName,
				$this->regSearchExp($customSearch->getSearchString())
			);
		}

		$this->getCustomEnableFields($this->query->getQuerySettings()->getStoragePageIds());
		$this->prepareQuery();

		$results = $this->query->execute();

		foreach ($results as $result) {
			if (in_array($this->type, $this->showBreadcrumbInSeachresult)) {
				($result->changeUidToPid)
						? $result->setBreadcrumb($this->getBreadcrumb($result->getUid()))
						: $result->setBreadcrumb($this->getBreadcrumb($result->getPid()));
			}
		}

		$this->logicalAnd = array();
		$this->logicalOr = array();

		return $results;
	}

	/**
	 * Prepares the query for execution
	 *
	 * @return void
	 */
	protected function prepareQuery() {
		$this->query->matching(
			$this->query->logicalAnd(
				$this->query->logicalAnd($this->logicalAnd),
				$this->query->logicalOr($this->logicalOr)
			)
		);
		$limit = ($this->maxResults) ? $this->maxResults : $this->settings['max_results'];
		$this->query->setLimit(intval($limit));
	}

	/**
	 * Sets the type of the Model
	 *
	 * @param $type
	 * @return void
	 */
	protected function setType($type) {
		if ($type === Page::class AND $this->sysLanguageUid !== 0) {
			$this->type = PageLanguageOverlay::class;
		} else {
			$this->type = $type;
		}
	}

	/**
	 * Set the QuerySettings
	 *
	 * @return void
	 */
	protected function setQuerySettings() {
		$this->query->getQuerySettings()
				->setRespectStoragePage(FALSE)
				->setRespectSysLanguage(TRUE);
	}

	/**
	 * Fills logicalAnd and logicalOr for the Query
	 *
	 * @param array $storagePids
	 * @return void
	 */
	protected function getCustomEnableFields($storagePids) {
		switch ($this->type) {
			case 'Sunzinet\SzIndexedSearch\Domain\Model\Page':
				array_push($this->logicalAnd, $this->query->equals('nav_hide', $this->settings['includeNavHiddenPages']));
				array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 254)));
				array_push($this->logicalAnd, $this->query->logicalNot($this->query->equals('doktype', 4)));
				break;
			case 'Sunzinet\SzIndexedSearch\Domain\Model\File':
				$enablefields = explode(',', $this->settings['customEnableFields']['file']['fieldname']);
				$constraints = array();
				foreach ($enablefields as $field) {
					$constraints[] = $this->query->equals('fieldname', trim($field));
				}
				array_push($this->logicalAnd,$this->query->equals('tablenames', 'tt_content'));
				array_push($this->logicalAnd, $this->query->logicalOr($constraints));
				break;
			default:
		}

		foreach ($storagePids as $storagePid) {
			array_push($this->logicalOr, $this->query->in('pid', $this->extendPidListByChildren($storagePid, 6)));
		}

		array_push($this->logicalAnd, $this->query->logicalOr($this->constraints));
	}

	/**
	 * Prepare string with given reqExp
	 *
	 * @param $searchString
	 * @return mixed|string
	 */
	protected function regSearchExp($searchString) {
		$searchString = urldecode($searchString);
		$searchString = $GLOBALS['TYPO3_DB']->escapeStrForLike($searchString, 'pages');
		$searchString = $GLOBALS['TYPO3_DB']->quoteStr($searchString, 'pages');
		if ($this->settings['reg_search_exp']) {
			$searchString = str_replace('|', $searchString, $GLOBALS['TYPO3_DB']->quoteStr($this->settings['reg_search_exp'], 'pages'));
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

		$queryGenerator = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Database\\QueryGenerator');
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
	 * Builds breadcrumbs
	 *
	 * @param int $pid Page Id
	 * @return string The Breadcrumb
	 */
	protected function getBreadcrumb($pid) {
		/** @var $pageSelect PageRepository */
		$pageSelect = $this->objectManager->get(PageRepository::class);
		$pageSelect->init(FALSE);

		$result = '';
		$i = 0;
		foreach (array_reverse($pageSelect->getRootLine($pid)) as $breadcrumb) {
			if ($this->sysLanguageUid != 0) {
				$page = $pageSelect->getPageOverlay($breadcrumb['uid'], $this->sysLanguageUid);
			} else {
				$page = $pageSelect->getPage($breadcrumb['uid'], $this->sysLanguageUid);
			}
			if (!$page) {
				$page = $pageSelect->getPage($breadcrumb['uid'], $this->sysLanguageUid);
			}
			$pageTitle = $page['tx_realurl_pathsegment'] ? ucfirst($page['tx_realurl_pathsegment']) : ucfirst($page['title']);
			if (!empty($page) AND $page['nav_hide'] != '1' AND $page['tx_realurl_exclude'] != '1') {
				if ($i > 0) {
					$result .= ' ' . $this->settings['breadcrumb_seperator'] . ' ';
				}
				$result .= $pageTitle;
				$i++;
			}
		}

		return $result;
	}

}
