<?php

namespace Sunzinet\SzQuickfinder\Tests\Settings;

/**
 * Class TyposcriptSettingsTest
 */
class TyposcriptSettingsTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{
    /**
     * @var \Sunzinet\SzQuickfinder\TyposcriptSettings $subject
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new \Sunzinet\SzQuickfinder\Settings\TyposcriptSettings([]);
    }

    /**
     * @test
     */
    public function setUnavailablePropertyThrowsException()
    {
        $this->expectException(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\Exception\NonExistentPropertyException::class);
        $this->subject->setProperty('thisPropertyDoesNotExist', 'foobar');
    }

    /**
     * @test
     */
    public function setPropertyClass()
    {
        $this->subject->setProperty('class', 'FooBar');
        $this->assertTrue(($this->subject->getClass() === 'FooBar'));
    }

    /**
     * @test
     */
    public function setPropertyRegEx()
    {
        $this->subject->setProperty('regEx', '%|%');
        $this->assertTrue(($this->subject->getRegEx() === '%|%'));
    }

    /**
     * @test
     */
    public function setPropertyMaxResultsWithType()
    {
        $this->subject->setProperty('maxResults', '7');
        $this->assertSame(7, $this->subject->getMaxResults());
        $this->subject->setProperty('maxResults', 7);
        $this->assertSame(7, $this->subject->getMaxResults());
    }

    /**
     * @test
     */
    public function setPropertyIncludeNavHiddenPages()
    {
        $this->subject->setProperty('includeNavHiddenPages', '1');
        $this->assertSame(true, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', 1);
        $this->assertSame(true, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', 'true');
        $this->assertSame(true, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', true);
        $this->assertSame(true, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', '0');
        $this->assertSame(false, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', 0);
        $this->assertSame(false, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', 'false');
        $this->assertSame(false, $this->subject->getIncludeNavHiddenPages());

        $this->subject->setProperty('includeNavHiddenPages', false);
        $this->assertSame(false, $this->subject->getIncludeNavHiddenPages());
    }

    /**
     * @test
     */
    public function setPropertySearchFields()
    {
        $this->subject->setProperty('searchFields', 'foo,bar, foobar');
        $this->assertSame(['foo', 'bar', 'foobar'], $this->subject->getSearchfields());
    }

    /**
     * @test
     */
    public function setPropertyAllowedFieldnames()
    {
        $this->subject->setProperty('allowedFieldnames', 'foo,bar, foobar');
        $this->assertSame(['foo', 'bar', 'foobar'], $this->subject->getAllowedFieldnames());
    }

    /**
     * @test
     */
    public function setPropertySearchString()
    {
        $this->subject->setProperty('searchString', 'foobar');
        $this->assertSame('foobar', (string)$this->subject->getSearchString());
    }

    /**
     * @test
     */
    public function setPropertyOrderBy()
    {
        $this->subject->setProperty('orderBy', 'uid');
        $this->assertSame('uid', $this->subject->getOrderBy());
    }

    /**
     * @test
     */
    public function setPropertyAscending()
    {
        $this->subject->setProperty('ascending', '1');
        $this->assertSame(true, $this->subject->getAscending());

        $this->subject->setProperty('ascending', 1);
        $this->assertSame(true, $this->subject->getAscending());

        $this->subject->setProperty('ascending', 'true');
        $this->assertSame(true, $this->subject->getAscending());

        $this->subject->setProperty('ascending', true);
        $this->assertSame(true, $this->subject->getAscending());

        $this->subject->setProperty('ascending', '0');
        $this->assertSame(false, $this->subject->getAscending());

        $this->subject->setProperty('ascending', 0);
        $this->assertSame(false, $this->subject->getAscending());

        $this->subject->setProperty('ascending', 'false');
        $this->assertSame(false, $this->subject->getAscending());

        $this->subject->setProperty('ascending', false);
        $this->assertSame(false, $this->subject->getAscending());
    }

    /**
     * @test
     */
    public function setPropertyScript()
    {
        $this->subject->setProperty('script', '/path/to/script');
        $this->assertSame('/path/to/script', $this->subject->getScript());
    }

    /**
     * @test
     */
    public function setPropertyParams()
    {
        $this->subject->setProperty('params', ['foo', 'bar']);
        $this->assertSame(['foo', 'bar'], $this->subject->getParams());
    }

    /**
     * @test
     */
    public function propertyWillBeSetIfPropertyExists()
    {
        $this->subject->setProperty('class', 'FooBar');
        $this->assertSame('FooBar', $this->subject->getClass());
    }

    /**
     * @test
     */
    public function constructorArgumentsWillBeConvertedToProperties()
    {
        $subject = new \Sunzinet\SzQuickfinder\Settings\TyposcriptSettings([
            'class' => 'Foo\bar',
            'regEx' => '%|%',
            'maxResults' => '7',
            'includeNavHiddenPages' => true,
            'searchFields' => 'foo, bar,foobar',
            'allowedFieldnames' => 'foobar',
            'searchString' => 'Lorem',
            'orderBy' => 'foobar',
            'ascending' => 'true',
            'script' => '/foo/bar',
            'params' => 'foo, bar',
            'blacklistPid' => 1234,
        ]);

        $this->assertSame('Foo\bar', $subject->getClass());
        $this->assertSame('%|%', $subject->getRegEx());
        $this->assertSame(7, $subject->getMaxResults());
        $this->assertSame(true, $subject->getIncludeNavHiddenPages());
        $this->assertSame(['foo', 'bar', 'foobar'], $subject->getSearchFields());
        $this->assertSame(['foobar'], $subject->getAllowedFieldnames());

        $this->assertSame('Lorem', (string)$subject->getSearchString());

        $this->assertSame('foobar', $subject->getOrderBy());
        $this->assertSame(true, $subject->getAscending());
        $this->assertSame('/foo/bar', $subject->getScript());
        $this->assertSame(['foo', 'bar'], $subject->getParams());
        $this->assertSame([0 => '1234'], $subject->getBlacklistPid());
    }

    public function tearDown()
    {
        unset($GLOBALS['TYPO3_DB']);
    }
}
