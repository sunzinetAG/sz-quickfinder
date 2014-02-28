<?php

class Tx_SzIndexedSearch_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * autocomplete Action
	 * Builds the JSON for the search results
	 *
	 * @param string $searchValue
	 * @return string json encoded string
	 */
	public function autocompleteAction($searchValue = '') {

		return json_encode(
			array(
				'suggestions' => $this->getSuggestions($searchValue)
			)
		);
	}

	/**
	 * Calls all the possible suggestions
	 *
	 * @param string $searchValue
	 * @return array
	 */
	protected function getSuggestions($searchValue) {

		if($this->settings['enable_documents']) {
			$filelinks = $this->getFilelinks($searchValue);
			if(!empty($filelinks)) {
				array_push($filelinks, '<h4 class="documents">' . Tx_Extbase_Utility_Localization::translate('documents', $this->extensionName) . '</h4>');
			}
		} else {
			$filelinks = array();
		}

		$suggestions = array_merge($filelinks);

		// custom Queries
		foreach($this->settings['customSearch'] as $headline => $customSearch) {
			$customResults = $this->getCustomResults($searchValue, $customSearch);
			if(!empty($customResults)) {
				array_push($customResults, '<h4 class="' . strtolower($headline) . '">' . Tx_Extbase_Utility_Localization::translate(strtolower($headline), $this->extensionName) . '</h4>');
			} else {
				$customResults = array();
			}
			$suggestions = ($customSearch['important']) ? array_merge($suggestions, $customResults) : array_merge($customResults, $suggestions);
		}

		if(!empty($suggestions)) {
			array_push($suggestions, '<h3>'.Tx_Extbase_Utility_Localization::translate('quicklaunch', $this->extensionName).'</h3>');
		}

		$suggestions = array_reverse($suggestions);
		if($this->settings['additional_button']) {
			array_push($suggestions, '<a href="#" class="submit tx-indexedsearch-searchbox-sword-trigger">'.Tx_Extbase_Utility_Localization::translate('all_search_results', $this->extensionName).'</a>');
		}

		return $suggestions;
	}

	/**
	 * Gets all the filelinks content-elements and return the files if searched for the "File description" or the Title
	 *
	 * @param string $searchValue
	 * @return array with links to the pdf documents
	 */
	protected function getFilelinks($searchValue) {
		$searchValue = $this->regSearchExp($searchValue);
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
		$table = 'tt_content';
		$select = 'imagecaption, media, pid';
		$enableFields = $GLOBALS['TSFE']->sys_page->enableFields($table, -1, array('fe_group' => 1));
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$select,
			$table,
			'CType = "uploads" AND (imagecaption LIKE "' . $searchValue . '" OR media LIKE "' . $searchValue . '" ) ' . $enableFields . ' ',
			'',
			''
		);

		$fileFolder = 'uploads/media/';
		$filelinks = array();
		$searchValue = str_replace('%', '', $searchValue);
		if (!empty($rows)) {
			foreach ($rows as $row) {
				// split field-content
				$imagecaptionContent = explode(PHP_EOL, $row['imagecaption']);
				$mediaContent = explode(',', $row['media']);
				$count = 0;
				foreach($mediaContent as $src){
					if(isset($imagecaptionContent[$count]) &&
							strpos( strtolower($imagecaptionContent[$count]), strtolower($searchValue)) !== FALSE){
						$imagecaption = $imagecaptionContent[$count];
						$media = $src;

						$href = $fileFolder . $media;

						if(include_once(PATH_site.'/typo3conf/ext/naw_securedl/Classes/Service/Tx_NawSecuredlService.php')){
							/* @var $objSecureDownloads tx_nawsecuredl */
							$objSecureDownloads = t3lib_div::makeInstance('Tx_NawSecuredlService');

							$href = t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $objSecureDownloads->makeSecure($href);
						}

						if($this->settings['highlight_search_results']) {
							$imagecaption = $this->highlight($imagecaption, $searchValue);
						}

						if($this->settings['show_breadcrumbs_to_documents']) {
							$breadcrumbs = '<div class="document_breadcrumbs breadcrumbs">' . $this->getBreadcrumbs($row['pid']) . '</div>';
						} else {
							$breadcrumbs = '';
						}
						$file = '<a href="' . $href . '" target="_blank">'. $imagecaption . $breadcrumbs . '</a>';
						$filelinks[] = $file;
					}
					$count++;
				}
			}
		}
		$filelinks = array_slice($filelinks, 0, $this->settings['max_results']);

		return $filelinks;
	}

	/**
	 * Builds custom queries and returns them in an array
	 *
	 * @param string $searchValue
	 * @param array $searchConditions
	 * @return array
	 */
	protected function getCustomResults($searchValue, $searchConditions) {
		$searchValue = $this->regSearchExp($searchValue);
		$table = $searchConditions['table'];
		$select = '*';
		$where = '(';
		$fields = explode(',',$searchConditions['searchFields']);
		$fields = str_replace(' ', '', $fields);
		$i = 0;
		foreach($fields as $field) {
			if($i > 0) {
				$where .= ' OR ';
			}
			$where .= $field . ' LIKE "' . $searchValue . '"';
			$i++;
		}
		$where .= ')';
		$i = 0;
		if($searchConditions['where']) {
			$whereConditions = explode(',',$searchConditions['where']);
			$whereConditions= str_replace(' ', '', $whereConditions);
			$where .= ' AND ';
			foreach($whereConditions as $whereCondition) {
				if($i > 0) {
					$where .= ' AND ';
				}
				$where .= $whereCondition;
				$i++;
			}
		}

		$enableFields = ($table == 'tt_content' || $table = 'pages') ? $GLOBALS['TSFE']->sys_page->enableFields($table) : $enableFields = ' AND pid<>-1 AND starttime<=' . time() . ' AND (endtime=0 OR endtime>' . time() . ')';
		$pageroot = $this->settings['pageroot'] ? $this->settings['pageroot'] : 1;

		$allowedPages = join(',', $this->getSubPages($pageroot));
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			$select,
			$table,
			$where.$enableFields. ' AND pid IN (' . $allowedPages . ') ',
			'',
			'',
			$this->settings['max_results']
		);

		$pages = array();
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$pages[] = '<a href="' . $this->createUrl($row['uid']) . '">'. $row['title'] .'</a>';
			}
		}

		$hash = md5(microtime());
		$customResults = array();
		if(!empty($rows)) {
			foreach($rows as $row) {
				$title = $searchConditions['title'];
				foreach($fields as $field) {
					$title = str_replace('{$'.$field.'}', $hash.$field.$hash, $title);
				}
				foreach($fields as $field) {
					$title = str_replace($hash.$field.$hash, $row[$field], $title);
				}

				$pageId = ($searchConditions['linkField']) ? $row[$searchConditions['linkField']] : $row['pid'];
				if($this->settings['highlight_search_results']) {
					$title = $this->highlight($title, str_replace('%', '', $searchValue));
				}
				$title = str_replace('{$breadcrumbs}', $this->getBreadcrumbs($pageId), $title);
				$customResults[] = '<a href="' . $this->createUrl($pageId) . '#c' . $row['uid'] . '">'. $title .'</a>';
			}
		}

		return $customResults;

	}

	/**
	 * Builds breadcrumbs
	 *
	 * @param int $pid
	 * @return string The breadcrumbs
	 */
	protected function getBreadcrumbs($pid) {
		$pageSelect = new t3lib_pageSelect();
		$pageSelect->init(TRUE);

		$result = '';
		$i = 0;
		$homePageUid = $this->settings['homePageUid'] ? $this->settings['homePageUid'] : 1;
		foreach(array_reverse($pageSelect->getRootLine($pid)) as $breadcrumb) {
			$page = $pageSelect->getPage($breadcrumb['uid']);
			if(!$page['nav_hide'] && $page['uid'] != $homePageUid) {
				if($i > 0) {
					$result .= ' > ';
				}
				$result .= $page['title'];
				$i++;
			}
		}
		return $result;
	}

	/**
	 * Highlights the search string
	 *
	 * @param string $imagecaption
	 * @param string $searchValue
	 * @return string
	 */
	protected function highlight($imagecaption, $searchValue) {
		$occurrences = substr_count(strtolower($imagecaption), strtolower($searchValue));
		$return = $imagecaption;
		$match = array();

		for ($i=0;$i<$occurrences;$i++) {
			$match[$i] = stripos($imagecaption, $searchValue, $i);
			$match[$i] = substr($imagecaption, $match[$i], strlen($searchValue));
			$return = str_replace($match[$i], '[#]'.$match[$i].'[@]', $return);
		}

		$return = str_replace('[#]', '<strong>', $return);
		$return = str_replace('[@]', '</strong>', $return);
		return $return;
	}

	protected function regSearchExp($searchValue) {
		$searchValue = $GLOBALS['TYPO3_DB']->escapeStrForLike($searchValue, 'pages');
		if($this->settings['reg_search_exp']) {
			$searchValue = str_replace('|', $searchValue, $this->settings['reg_search_exp']);
		} else {
			$searchValue = '%' . $searchValue . '%';
		}
		return $searchValue;
	}

	/**
	 * Creates a valid URL
	 *
	 * @param int $uid
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