<?php

/**
 * Description of the phpfile 'versionCompatibility.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

/**
 * Alle Funktionen, die in
 *
 * Class Tx_szIndexedSearch_Utility_VersionCompatibility
 */
class Tx_szIndexedSearch_Utility_VersionCompatibility extends Tx_Extbase_Persistence_Repository {

	/**
	 * @param $query Tx_Extbase_Persistence_QueryInterface
	 * @return mixed
	 */
	public function getLanguageUid(Tx_Extbase_Persistence_QueryInterface $query) {
		if(!$this->isTypoThreeSixTwo()) {
			return $GLOBALS['TSFE']->sys_language_uid;
		}

		return $query->getQuerySettings()->getLanguageUid();
	}

	/**
	 * @param string $type
	 * @return mixed
	 */
	public function createQueryObject($type) {
		if(!$this->isTypoThreeSixTwo()) {
			return $this->queryFactory->create($type);
		}

		return $this->persistenceManager->createQueryForType($type);
	}

	/**
	 * Checks, if we are in TYPO3 V. >= 6.2.0
	 *
	 * @return bool
	 */
	public function isTypoThreeSixTwo() {
		if(t3lib_div::int_from_ver(TYPO3_version) < t3lib_div::int_from_ver('6.2.0')) {
			return false;
		} else {
			return true;
		}
	}

}

?>