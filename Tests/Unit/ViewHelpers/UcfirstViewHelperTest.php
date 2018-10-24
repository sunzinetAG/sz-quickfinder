<?php
namespace Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format;

use Sunzinet\SzQuickfinder\ViewHelpers\Format\UcfirstViewHelper;

/**
 * Class UcfirstViewHelperTest
 * @package Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format
 */
class UcfirstViewHelperTest extends \Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase
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
        $this->viewHelper = $this->createMock($this->buildAccessibleProxy(UcfirstViewHelper::class), array('renderChildren'));
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

        $this->expectException('InvalidArgumentException');
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

        $this->expectException('InvalidArgumentException');
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

        $this->expectException('InvalidArgumentException');
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

        $this->expectException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $this->viewHelper->render());
    }
}
