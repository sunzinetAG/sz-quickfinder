<?php
namespace Sunzinet\SzIndexedSearch\Tests\ViewHelpers\Format;

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
use Sunzinet\SzIndexedSearch\ViewHelpers\Format\HighlightViewHelper;
use TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\ViewHelperBaseTestcase;

/**
 * Test case for class \Sunzinet\ViewHelpers\Format\UcfirstViewHelperTest.
 *
 * @version 3.0.0
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package Sunzinet\ViewHelpers\Format
 * @subpackage Indexed Search Extend
 *
 * @author Dennis Römmich <dennis.roemmich@sunzinet.com>
 */
class HighlightViewHelperTest extends ViewHelperBaseTestcase {

	/**
	 * viewhelper
	 *
	 * @var HighlightViewHelper $viewHelper
	 */
	protected $viewHelper;

	/**
	 * searchString
	 *
	 * @var string $searchString
	 */
	protected $searchString = 'nodes';

	/**
	 * setUp
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->viewHelper = $this->getMockBuilder(HighlightViewHelper::class)
				->setMethods(array('renderChildren'))
				->getMock();
		$this->injectDependenciesIntoViewHelper($this->viewHelper);
	}

	/**
	 * searchStringContainsEmptyStringByDefault
	 *
	 * @test
	 * @return void
	 */
	public function searchStringContainsEmptyStringByDefault() {
		$searchString = $this->readAttribute($this->viewHelper, 'searchString');
		$this->assertSame('', $searchString);
	}

	/**
	 * renderOutputsReturnsHighlightedString
	 *
	 * @test
	 * @return void
	 */
	public function renderOutputsReturnsHighlightedString() {
		$reflection = new \ReflectionClass($this->viewHelper);
		$property = $reflection->getProperty('searchString');
		$property->setAccessible(TRUE);
		$property->setValue($this->viewHelper, 'nodes');

		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('child nodes'));

		$this->assertSame('child <strong>nodes</strong>', $this->viewHelper->render());
	}

	/**
	 * setObjectAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setObjectAsSearchStringThrowsException() {
		$stdClass = new \stdClass();
		$method = $this->getProtectedMethod('setSearchString');

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, array($stdClass)));
	}

	/**
	 * setIntegerAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setIntegerAsSearchStringThrowsException() {
		$integer = intval(5);
		$method = $this->getProtectedMethod('setSearchString');

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, array($integer)));
	}

	/**
	 * setNullAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setNullAsSearchStringThrowsException() {
		$method = $this->getProtectedMethod('setSearchString');

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, array(NULL)));
	}

	/**
	 * setNullAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setEmptyStringAsSearchStringThrowsException() {
		$method = $this->getProtectedMethod('setSearchString');

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, array('')));
	}

	/**
	 * getProtectedMethod
	 *
	 * @param string $name
	 * @return \ReflectionMethod
	 */
	protected function getProtectedMethod($name = '') {
		$class = new \ReflectionClass(HighlightViewHelper::class);
		$method = $class->getMethod($name);
		$method->setAccessible(TRUE);
		return $method;
	}

}
