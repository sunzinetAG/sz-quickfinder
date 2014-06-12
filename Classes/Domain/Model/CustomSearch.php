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
class Tx_SzIndexedSearch_Domain_Model_CustomSearch {

	//	Todo: description

	protected $table;

	protected $searchFields;

	protected $where;

	protected $title;

	protected $linkField;

	protected $important;

	protected $searchString;

	public function setTable($table) {
		$this->table = $table;
	}

	public function getTable() {
		return $this->table;
	}

	public function setSearchFields($searchFields) {
		$this->searchFields = $searchFields;
	}

	public function getSearchFields() {
		return $this->searchFields;
	}

	public function setWhere($where) {
		$this->where = $where;
	}

	public function getWhere() {
		return $this->where;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setLinkField($linkField) {
		$this->linkField = $linkField;
	}

	public function getLinkField() {
		return $this->linkField;
	}

	public function setImportant($important) {
		$this->important = $important;
	}

	public function getImportant() {
		return $this->important;
	}

	public function setSearchString($searchString) {
		$this->searchString = $searchString;
	}

	public function getSearchString() {
		return $this->searchString;
	}

}
?>