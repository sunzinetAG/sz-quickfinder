<?php
namespace Sunzinet\SzIndexedSearch\Utility;

use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Frontend\Utility\EidUtility;

/***************************************************************
 *  Copyright notice
 *  (c) 17.09.2015 BjÃ¶rn Christopher Bresser (bjoern.bresser@sunzinet.com)
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/*
 * Example for controller-calls
 * =======================================
 * var request = {
 *			id: 1,
 *			mvc: {
 *				vendor: 'GeorgRinger',
 *				extensionName: 'News',
 *				pluginName: 'pi1',
 *				controller: 'News',
 *				action: 'list',
 *				format: 'html'
 *			},
 *			arguments: {
 *				'foo': 'bar'
 *			}
 *		};
 *
 *		jQuery.ajax({
 *			url: 'index.php',
 *			type: 'GET',
 *			dataType: 'html',
 *			data: {
 *				eID: 'ajaxDispatcher',
 *				request: request
 *			},
 *			success: function (result) {
 *				jQuery('#newsReplace').html(result);
 *			}
 *		});
 */

/**
 * Class AjaxDispatcher
 *
 * @package Sunzinet\SzIndexedSearch\Utility
 */
class AjaxDispatcher
{

	/** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
	private $objectManager;

	/**
	 * Main function of the class, will run the function call process.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		// Bootstrap initialization.
		Bootstrap::getInstance()
			->initializeTypo3DbGlobal()
			->initializeBackendUser();

		// Gets the Ajax call parameters.
		$arguments = GeneralUtility::_GP('request');

		// Initializing TypoScript Frontend Controller.
		if (TYPO3_MODE == 'FE') {
			// Creating global time tracker.
			$GLOBALS['TT'] = $this->objectManager->get(\TYPO3\CMS\Core\TimeTracker\TimeTracker::class);

			$id = (isset($arguments['id'])) ? $arguments['id'] : 0;
			$this->initializeTsfe($id);
		}

		// If the argument "mvc" is sent, then we should be able to call a controller.
		if (isset($arguments['mvc'])) {
			$result = $this->callExtbaseController($arguments);
		} else {
			$result = $this->callUserFunction($arguments);
		}

		// Display the final result on screen.
		echo $result;
	}

	/**
	 * @param $arguments
	 * @return mixed
	 */
	private function callExtbaseController($arguments)
	{
		$mvcArguments = array(
			'extensionName' => '',
			'pluginName' => '',
			'vendorName' => '',
			'controller' => '',
			'switchableControllerActions' => ''
		);
		ArrayUtility::mergeRecursiveWithOverrule($mvcArguments, $arguments['mvc']);
		$pluginName = $mvcArguments['pluginName'];
		if (TYPO3_MODE == 'BE') {
			if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions'][$mvcArguments['extensionName']]['modules'])) {
				foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions'][$mvcArguments['extensionName']]['modules'] as $pluginKey) {
					if (preg_match('#^[^_]+_' . $mvcArguments['extensionName'] . $mvcArguments['pluginName'] . '$#', $pluginKey)) {
						$pluginName = $pluginKey;
						break;
					}
				}
			}
		}
		$bootstrapConfiguration = array(
			'extensionName' => $mvcArguments['extensionName'],
			'pluginName' => $pluginName,
			'vendorName' => $mvcArguments['vendor'],
			'controller' => $mvcArguments['controller'],
			'switchableControllerActions' => array(
				$mvcArguments['controller'] => array($mvcArguments['action'])
			)
		);
		$bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
		$bootstrap->initialize($bootstrapConfiguration);
		$bootstrap->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);
		$request = $this->objectManager->get('TYPO3\CMS\Extbase\Mvc\Request');
		$request->setControllerVendorName($arguments['mvc']['vendor']);
		$request->setControllerExtensionName($arguments['mvc']['extensionName']);
		$request->setPluginName($arguments['mvc']['pluginName']);
		$request->setControllerName($arguments['mvc']['controller']);
		$request->setControllerActionName($arguments['mvc']['action']);
		$request->setArguments($arguments['arguments']);
		$request->setFormat($arguments['mvc']['format']);
		$response = $this->objectManager->get('TYPO3\CMS\Extbase\Mvc\ResponseInterface');
		$dispatcher = $this->objectManager->get('TYPO3\CMS\Extbase\Mvc\Dispatcher');
		$dispatcher->dispatch($request, $response);

		return $response->getContent();
	}

	/**
	 * Run a user function call. See documentation for more information.
	 *
	 * @param   array $arguments Array containing the request arguments.
	 * @return  string  The result of the user function.
	 */
	private function callUserFunction($arguments)
	{
		/** @var $contentObjectRenderer \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer */
		$contentObjectRenderer = GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer'
		);
		/** @var $userContentObject \TYPO3\CMS\Frontend\ContentObject\UserContentObject */
		$userContentObject = $contentObjectRenderer->getContentObject('USER');

		$configuration = (isset($arguments['arguments'])) ? $arguments['arguments'] : array();
		$configuration['userFunc'] = $arguments['function'];

		$result = $userContentObject->render($configuration);
	}

	/**
	 * Initializes the $GLOBALS['TSFE'] var, useful everywhere when in a
	 * Frontend context.
	 *
	 * @param int $id
	 * @return void
	 */
	private function initializeTsfe($id)
	{
		if (TYPO3_MODE == 'FE') {

			/** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController */
			$GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
				'TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController',
				$GLOBALS['TYPO3_CONF_VARS'],
				$id,
				0
			);

			EidUtility::initLanguage();
			EidUtility::initTCA();

			// No Cache for Ajax stuff.
			$GLOBALS['TSFE']->set_no_cache();
			$GLOBALS['TSFE']->initFEuser();
			$GLOBALS['TSFE']->checkAlternativeIdMethods();
			$GLOBALS['TSFE']->determineId();
			$GLOBALS['TSFE']->initTemplate();
			$GLOBALS['TSFE']->getPageAndRootline();
			$GLOBALS['TSFE']->getConfigArray();
			$GLOBALS['TSFE']->connectToDB();
			$GLOBALS['TSFE']->settingLanguage();
			$GLOBALS['TSFE']->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
				\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class
			);
			$GLOBALS['TSFE']->settingLocale();
		}
	}

	/**
	 * Activates the Ajax Dispatcher.
	 * Should be called from "ext_localconf.php".
	 *
	 * @param bool $frontend
	 * @param bool $backend
	 * @param string $name
	 */
	public static function activateAjaxDispatcher($frontend = true, $backend = true, $name = 'szIsDispatcher')
	{
		if (TYPO3_MODE == 'BE' && $backend) {
			ExtensionManagementUtility::registerAjaxHandler($name, __CLASS__ . '->run');
		}
		if (TYPO3_MODE == 'FE' && $frontend) {
			$TYPO3_CONF_VARS['FE']['eID_include'][$name] = __FILE__;
		}
	}
}

if (TYPO3_MODE == 'FE' && (GeneralUtility::_GET('eID') === 'szIsDispatcher')) {
	/** @var $ajaxDispatcher AjaxDispatcherUtility */
	$ajaxDispatcher = new AjaxDispatcher();
	$ajaxDispatcher->run();
}