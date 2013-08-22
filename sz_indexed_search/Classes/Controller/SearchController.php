<?php

class Tx_SzIndexedSearch_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {
	/**
	 * Autocomplete Action
	 *
	 * @param string $searchValue
	 * @return string json encoded string
	 */
	public function autocompleteAction($searchValue = '') {

		return json_encode(
			array(
				'suggestions' => $this->getPages($searchValue)
			)
		);
	}

	/**
	 * @param $searchValue
	 * @return array
	 */
	protected function getPages($searchValue) {
		$pageroot = $this->settings['pageroot'] ? $this->settings['pageroot'] : 1;
		$allowedPages = join(',', $this->getSubPages($pageroot));
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$table = $GLOBALS['TSFE']->sys_language_uid !== 0 ? 'pages_language_overlay' : 'pages';
		$select = $GLOBALS['TSFE']->sys_language_uid !== 0 ? 'pid as uid,title' : 'uid,title';
		$enableFields = $GLOBALS['TSFE']->sys_page->enableFields($table);
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$select,
			$table,
			'title LIKE "%' . $GLOBALS['TYPO3_DB']->escapeStrForLike($searchValue, 'pages') . '%" AND doktype !=4 AND doktype !=254' . $enableFields . ' AND uid IN (' . $allowedPages. ') AND nav_hide = 1',
			'',
			'',
			10
		);
		$pages = array();
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$pages[] = '<a href="' . $this->createUrl($row['uid']) . '">'. $row['title'] .'</a>';
			}
		}

		return $pages;
	}

	/**
	 * @param $uid
	 * @param int $language
	 * @return string
	 */
	protected function createUrl($uid, $language = 0) {
		$arguments = array(
			"L" => $language
		);
		$pagepath = $this->uriBuilder->setArguments($arguments)->setTargetPageUid($uid)->build();
		return t3lib_div::locationHeaderUrl($pagepath);
	}

	/**
	 * Recursivly get all Sub pages for a page Uid
	 *
	 * @param int $pageUid
	 * @return array
	 */
	protected function getSubPages($pageUid = 1) {

		$pageSelect = new t3lib_pageSelect();
		$pageSelect->init(TRUE);

		$pageTree = $pageSelect->getMenu($pageUid);
		if (!empty($pageTree)) {
			$pages = array();
			foreach($pageTree as $page) {;
				if (isset($page['uid'])) {
					$pages[] = $page['uid'];
				}
			}
			foreach($pages as $page) {
				$values = $this->getSubPages($page);
				if (!empty($values)) {
					foreach($values as $value) {
						$pages[] = $value;
					}
				}
			}
			return $pages;
		}
	}

}