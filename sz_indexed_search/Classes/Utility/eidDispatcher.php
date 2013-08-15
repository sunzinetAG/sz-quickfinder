<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Armin Rüdiger Vieweg <armin.vieweg@sunzinet.com>, Robin Rossow <robin.rossow@sunzinet.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Dispatcher for eID
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class tx_SzIndexedSearch_eidDispatcher {
	/**
	 * Initializes and runs an extbase controller
	 *
	 * @param string $extensionName Name of extension, in UpperCamelCase
	 * @param string $controller Name of controller, in UpperCamelCase
	 * @param string $action Optional name of action, in lowerCamelCase (without 'Action' suffix). Default is 'index'.
	 * @param string $pluginName Optional name of plugin. Default is 'Pi1'.
	 * @param array $settings Optional array of settings to use in controller and fluid template. Default is array().
	 *
	 * @return string output of controller's action
	 */
	protected function runExtbaseController($extensionName, $controller, $action = 'index', $pluginName = 'Pi1', $settings = array()) {
		$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], 0, 0);
		$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->config['config']['meaningfulTempFilePrefix'] = 100;
		$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], '', '');
		$GLOBALS['TSFE']->initFEuser();
		$GLOBALS['TSFE']->determineId();
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->getConfigArray();
		tslib_eidtools::connectDB();
		tslib_eidtools::initLanguage('default');
		tslib_eidtools::initTCA();
		$GLOBALS['TSFE']->fe_user = tslib_eidtools::initFeUser();
		tslib_eidtools::initExtensionTCA('sz_indexed_search');

		$bootstrap = new Tx_Extbase_Core_Bootstrap();
		$bootstrap->cObj = t3lib_div::makeInstance('tslib_cObj');

		$extensionTyposcriptSetup = $this->getExtensionTyposcriptSetup();
		$configuration = array(
			'pluginName' => $pluginName,
			'extensionName' => $extensionName,
			'controller' => $controller,
			'action' => $action,
			'mvc' => array('requestHandlers' => array('Tx_Extbase_MVC_Web_FrontendRequestHandler'=>'Tx_Extbase_MVC_Web_FrontendRequestHandler')),
			'settings' => $settings,
			'persistence' => $extensionTyposcriptSetup['plugin']['tx_szindexedsearch']['persistence'],
		);

		return $bootstrap->run('', $configuration);
	}

	/**
	 * Gets the typoscript setup defined in ext_typoscript_setup.txt as array
	 * @return array
	 */
	protected function getExtensionTyposcriptSetup() {
		/** @var $TSparser t3lib_TSparser */
		$TSparser = t3lib_div::makeInstance('t3lib_TSparser');

		$TSparser->parse(file_get_contents(t3lib_extMgm::extPath('sz_indexed_search') . 'ext_typoscript_setup.txt'));
		return Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($TSparser->setup);
	}

	/**
	 * Dispatches the autocomplete function of vouchers
	 * @return string the output of controller
	 */
	public function dispatchAutocompleteRequest() {
		return $this->runExtbaseController('SzIndexedSearch', 'Search', 'autocomplete', 'Pi99');
	}

}

/** @var $dispatcher tx_SzIndexedSearch_eidDispatcher */
$dispatcher = t3lib_div::makeInstance('tx_SzIndexedSearch_eidDispatcher');
if (t3lib_div::_GP('eID') === 'tx_szindexedsearch_autocomplete') {
	echo $dispatcher->dispatchAutocompleteRequest();
}