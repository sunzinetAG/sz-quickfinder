<?php

namespace Sunzinet\SzQuickfinder\Tests\Utility;

/**
 * Class SanitizeUtility
 */
class SanitizeUtilityTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{
    /**
     * @var \Sunzinet\SzQuickfinder\Utility\SanitizeInterface $subject
     */
    protected $subject;

    public function setUp()
    {
        $this->mockGlobalDatabase();
        $this->subject = new \Sunzinet\SzQuickfinder\Utility\SanitizeUtility('foobar');
    }

    /**
     * @test
     */
    public function stringGotSanitizedInConstructor()
    {
        $subject = new \Sunzinet\SzQuickfinder\Utility\SanitizeUtility('foobar');
        $this->assertTrue($subject->sanitized());
    }

    /**
     * @test
     */
    public function toStringReturnsString()
    {
        $this->assertSame('foobar', (string)$this->subject);
    }

    /**
     * @Todo: Can't be tested yet because of missing Database abstraction. Remove calls to $GLOBALS['TYPO3_DB'] and $this->mockGlobalDatabase()
     * @test
     */
    public function sanitize()
    {
        $subject = new \Sunzinet\SzQuickfinder\Utility\SanitizeUtility('foo\'bar');
        //@Todo: Is this the expected behavior?
        $this->assertSame('foobar', (string)$subject);

        $subject = new \Sunzinet\SzQuickfinder\Utility\SanitizeUtility('<b>foo\'bar</b>');
        $this->assertSame('foobar', (string)$subject);

        $subject = new \Sunzinet\SzQuickfinder\Utility\SanitizeUtility('<script type="text/javascript">foo\'bar</script>');
        $this->assertSame('foobar', (string)$subject);

        //@Todo: XSS Tests
    }

    /**
     * @return void
     */
    protected function mockGlobalDatabase()
    {
        $GLOBALS['TYPO3_DB'] = $this->createMock(\TYPO3\CMS\Core\Database\DatabaseConnection::class);
        $GLOBALS['TYPO3_DB']->method('escapeStrForLike')->willReturn('foobar');
        $GLOBALS['TYPO3_DB']->method('quoteStr')->willReturn('foobar');
    }

    public function tearDown()
    {
        unset($GLOBALS['TYPO3_DB']);
    }
}
