<?php
namespace Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format;

use Sunzinet\SzQuickfinder\ViewHelpers\Format\UcfirstViewHelper;
use TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\ViewHelperBaseTestcase;

/**
 * Class UcfirstViewHelperTest
 * @package Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format
 */
class UcfirstViewHelperTest extends ViewHelperBaseTestcase
{
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
    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = $this->getMock($this->buildAccessibleProxy(UcfirstViewHelper::class), array('renderChildren'));
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
        $this->viewHelper->initializeArguments();
    }

    /**
     * renderOutputsReturnsStringWithFirstCharacterUppercase
     *
     * @test
     * @return void
     */
    public function renderOutputsReturnsStringWithFirstCharacterUppercase()
    {
        $this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('lorem ipsum'));

        $this->assertSame('Lorem ipsum', $this->viewHelper->render());
    }

    /**
     * setObjectAsSearchStringThrowsException
     *
     * @test
     * @return void
     */
    public function setObjectAsSearchStringThrowsException()
    {
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
    public function setIntegerAsSearchStringThrowsException()
    {
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
    public function setNullAsSearchStringThrowsException()
    {
        $this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(null));

        $this->setExpectedException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $this->viewHelper->render());
    }

    /**
     * setNullAsSearchStringThrowsException
     *
     * @test
     * @return void
     */
    public function setEmptyStringAsSearchStringThrowsException()
    {
        $this->viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(''));

        $this->setExpectedException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $this->viewHelper->render());
    }
}
