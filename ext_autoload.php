<?php

/**
 * Description of the phpfile 'ext_autoload.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

$extensionPath = t3lib_extMgm::extPath('sz_indexed_search');
return array(
	'tx_szindexedsearch_utility_versioncompatibility' => $extensionPath . 'Classes/Utility/VersionCompatibilityUtility.php',
);

?>