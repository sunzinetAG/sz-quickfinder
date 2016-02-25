<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

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
 * Class Content
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class CustomSearch {

	/**
	 * table
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * searchFields
	 *
	 * @var array
	 */
	protected $searchFields;

	/**
	 * searchString
	 *
	 * @var string
	 */
	protected $searchString;

	/**
	 * script
	 *
	 * @var string
	 */
	protected $script = FALSE;

	/**
	 * maxResults
	 *
	 * @var int
	 */
	protected $maxResults;

	/**
	 * Sets the table
	 *
	 * @param string $table
	 * @return CustomSearch
	 */
	public function setTable($table) {
		$this->table = $table;

		return $this;
	}

	/**
	 * Returns the table
	 *
	 * @return string $table
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * Sets the searchFields
	 *
	 * @param array $searchFields
	 * @return CustomSearch
	 */
	public function setSearchFields($searchFields) {
		$this->searchFields = $searchFields;

		return $this;
	}

	/**
	 * Returns the searchFields
	 *
	 * @return array $searchFields
	 */
	public function getSearchFields() {
		return $this->searchFields;
	}

	/**
	 * Sets the searchString
	 *
	 * @param string $searchString
	 * @return CustomSearch
	 */
	public function setSearchString($searchString) {
		$this->searchString = $searchString;

		return $this;
	}

	/**
	 * Returns the searchString
	 *
	 * @return string $searchString
	 */
	public function getSearchString() {
		return $this->searchString;
	}

	/**
	 * Sets the scriptPath
	 *
	 * @param string $script
	 * @return CustomSearch
	 */
	public function setScript($script) {
		$this->script = $script;

		return $this;
	}

	/**
	 * Returns the scriptPath
	 *
	 * @return string
	 */
	public function getScript() {
		return $this->script;
	}

	/**
	 * Sets the maxResults
	 *
	 * @param int $maxResults
	 * @return CustomSearch
	 */
	public function setMaxResults($maxResults) {
		$this->maxResults = $maxResults;

		return $this;
	}

	/**
	 * Returns the maxResults
	 *
	 * @return int
	 */
	public function getMaxResults() {
		return $this->maxResults;
	}

}
