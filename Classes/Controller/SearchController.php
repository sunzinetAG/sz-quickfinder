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
class Tx_SzIndexedSearch_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * searchRepository
	 *
	 * @var Tx_SzIndexedSearch_Domain_Repository_SearchRepository
	 */
	protected $searchRepository;

	/**
	 * injectSearchRepository
	 *
	 * @param Tx_SzIndexedSearch_Domain_Repository_SearchRepository $searchRepository
	 * @return void
	 */
	public function injectSearchRepository(Tx_SzIndexedSearch_Domain_Repository_SearchRepository $searchRepository) {
		$this->searchRepository = $searchRepository;
	}

	/**
	 *
	 */
	public function indexAction() {
		$this->view->assign('searchPid', $this->settings['searchPid']);
	}

	/**
	 * @param string $searchString
	 * @return void
	 */
	public function autocompleteAction($searchString) {
		$customSearchArray = $this->settings['customSearch'];

		$results = array();

		foreach($customSearchArray as $sectionName => $customSearch) {
			$results[$sectionName] = $this->searchRepository->customSearch($this->buildModelFromTyposcript($customSearch, $searchString), $this->settings);
		}

		$this->view->assign('results', $results);
	}

	/**
	 * @param string $string
	 */
	public function searchAction($string) {
		$this->forward('search', 'Search', 'IndexedSearch', array('search'=> array('searchWords' => $string, 'searchParams' => $string, 'sword' => $string)));
//		$this->forward('autocomplete', 'Search', 'SzIndexedSearch', array('searchString' => 'test'));
	}

	protected function buildModelFromTyposcript($typoscript, $searchString) {
		/** @var $csObj Tx_SzIndexedSearch_Domain_Model_CustomSearch */
		$csObj = t3lib_div::makeInstance('Tx_SzIndexedSearch_Domain_Model_CustomSearch');
		$csObj->setTable($typoscript['table']);
		$csObj->setSearchFields(explode(',', str_replace(' ', '', $typoscript['searchFields'])));
		$csObj->setWhere($typoscript['where']);
		$csObj->setTitle($typoscript['title']);
		$csObj->setLinkField($typoscript['linkField']);
		$csObj->setImportant($typoscript['important']);
		$csObj->setSearchString($searchString);

		return $csObj;
	}

}
?>