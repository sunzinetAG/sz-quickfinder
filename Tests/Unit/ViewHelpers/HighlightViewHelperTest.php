<?php
namespace Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format;

use Sunzinet\SzQuickfinder\ViewHelpers\Format\HighlightViewHelper;

/**
 * Class HighlightViewHelperTest
 * @package Sunzinet\SzQuickfinder\Tests\ViewHelpers\Format
 */
class HighlightViewHelperTest extends \Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase
{
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
    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = $this->createPartialMock($this->buildAccessibleProxy(HighlightViewHelper::class), array('renderChildren'));
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
        $this->viewHelper->initializeArguments();
    }

    /**
     * searchStringContainsEmptyStringByDefault
     *
     * @test
     * @return void
     */
    public function searchStringContainsEmptyStringByDefault()
    {
        $searchString = $this->readAttribute($this->viewHelper, 'searchString');
        $this->assertSame('', $searchString);
    }

    /**
     * renderOutputsReturnsHighlightedString
     *
     * @test
     * @return void
     */
    public function renderOutputsReturnsHighlightedString()
    {
        $reflection = new \ReflectionClass($this->viewHelper);
        $property = $reflection->getProperty('searchString');
        $property->setAccessible(true);
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
    public function setObjectAsSearchStringThrowsException()
    {
        $stdClass = new \stdClass();
        $method = $this->getProtectedMethod('setSearchString');

        $this->expectException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, [$stdClass]));
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
        $method = $this->getProtectedMethod('setSearchString');

        $this->expectException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, [$integer]));
    }

    /**
     * setNullAsSearchStringThrowsException
     *
     * @test
     * @return void
     */
    public function setNullAsSearchStringThrowsException()
    {
        $method = $this->getProtectedMethod('setSearchString');

        $this->expectException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, [null]));
    }

    /**
     * setNullAsSearchStringThrowsException
     *
     * @test
     * @return void
     */
    public function setEmptyStringAsSearchStringThrowsException()
    {
        $method = $this->getProtectedMethod('setSearchString');

        $this->expectException('InvalidArgumentException');
        $this->assertSame($this->getExpectedException(), $method->invokeArgs($this->viewHelper, ['']));
    }

    /**
     * getProtectedMethod
     *
     * @param string $name
     * @return \ReflectionMethod
     */
    protected function getProtectedMethod($name = '')
    {
        $class = new \ReflectionClass(HighlightViewHelper::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
