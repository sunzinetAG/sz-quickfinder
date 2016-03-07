<?php
namespace Sunzinet\SzIndexedSearch\Tests\ViewHelpers\Format;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dennis R�mmich <dennis.roemmich@sunzinet.com>, sunzinet AG
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
use Sunzinet\SzIndexedSearch\ViewHelpers\Format\UcfirstViewHelper;
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
class UcfirstViewHelperTest extends ViewHelperBaseTestcase {

	/**
	 * viewhelper
	 *
	 * @var UcfirstViewHelper $viewHelper
	 */
	protected $viewHelper;

	/**
	 * setUp
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->viewHelper = $this->getMockBuilder(UcfirstViewHelper::class)
				->setMethods(array('renderChildren'))
				->getMock();
		$this->injectDependenciesIntoViewHelper($this->viewHelper);
	}

	/**
	 * renderOutputsReturnsStringWithFirstCharacterUppercase
	 *
	 * @test
	 * @return void
	 */
	public function renderOutputsReturnsStringWithFirstCharacterUppercase() {
		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('lorem ipsum'));

		$this->assertSame('Lorem ipsum', $this->viewHelper->render());
	}

	/**
	 * setObjectAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setObjectAsSearchStringThrowsException() {
		$stdClass = new \stdClass();
		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue($stdClass));

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $this->viewHelper->render());
	}

	/**
	 * setIntegerAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setIntegerAsSearchStringThrowsException() {
		$integer = intval(5);
		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue($integer));

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $this->viewHelper->render());
	}

	/**
	 * setNullAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setNullAsSearchStringThrowsException() {
		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(NULL));

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $this->viewHelper->render());
	}

	/**
	 * setNullAsSearchStringThrowsException
	 *
	 * @test
	 * @return void
	 */
	public function setEmptyStringAsSearchStringThrowsException() {
		$this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(''));

		$this->setExpectedException('InvalidArgumentException');
		$this->assertSame($this->getExpectedException(), $this->viewHelper->render());
	}

}
