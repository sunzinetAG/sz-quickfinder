<?php

namespace Sunzinet\SzQuickfinder\Tests\Repository;

use Sunzinet\SzQuickfinder\Domain\Model\Page;
use Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SearchRepositoryTest
 *
 * @package Sunzinet\SzQuickfinder\Tests\Controller
 */
class SearchRepositoryTest extends \Nimut\TestingFramework\TestCase\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/sz_quickfinder',
    ];

    /**
     * @var SearchRepository $subject
     */
    protected $subject;

    public function setUp()
    {
        parent::setUp();
        $this->importDataSet('ntf://Database/pages.xml');
        // Nasty hack because table mapping does not work
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('pages');
        $connection->executeQuery('CREATE TABLE IF NOT EXISTS tx_szquickfinder_domain_model_page AS SELECT * FROM pages;');
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/sz_quickfinder/Tests/Functional/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(1, [
            'EXT:sz_quickfinder/Tests/Functional/Fixtures/TypoScript/page.ts',
        ]);
        $objectManager = new \TYPO3\CMS\Extbase\Object\ObjectManager();
        $this->subject = $objectManager->get(SearchRepository::class);
        $this->mockPageRepository();
    }

    private function mockPageRepository()
    {
        $GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Page\PageRepository::class);
    }

    /**
     * @test
     */
    public function rootWillNotBeFoundBecausItsARootPage()
    {
        $results = $this->buildSearch('Root');
        $this->assertSame(0, $results->count());
    }

    /**
     * @test
     */
    public function dummyWillBeFoundThreeTimesBecauseMaxLimit()
    {
        $results = $this->buildSearch('Dummy');
        $this->assertSame(3, $results->count());
    }

    /**
     * @test
     */
    public function searchEndOfString()
    {
        $results = $this->buildSearch('5', '%|');
        $this->assertSame(1, $results->count());
    }

    /**
     * @test
     */
    public function searchWithoutLimit()
    {
        $results = $this->buildSearch('1', '%|%', ['title'], 99);
        $this->assertSame(5, $results->count());
    }

    /**
     * Build search for tests
     *
     * @param $searchString
     * @param string $regEx
     * @param array $searchFields
     * @param int $maxResults
     * @param string $orderBy
     * @param array $blackListPid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    protected function buildSearch(
        $searchString,
        $regEx = '%|%',
        $searchFields = ['title'],
        $maxResults = 3,
        $orderBy = 'uid',
        $blackListPid = [0]
    ) {
        // mock settings
        $settings = $this->createMock(\Sunzinet\SzQuickfinder\TyposcriptSettings::class);
        $settings->method('getRegEx')->willReturn($regEx);
        $settings->method('getClass')->willReturn(Page::class);
        $settings->method('getSearchString')->willReturn($searchString);
        $settings->method('getSearchFields')->willReturn($searchFields);
        $settings->method('getMaxResults')->willReturn($maxResults);
        $settings->method('getOrderBy')->willReturn($orderBy);
        $settings->method('getBlacklistPid')->willReturn($blackListPid);

        // moc search
        $search = $this->createMock(Page::class);
        $search->method('getSettings')->willReturn($settings);

        $this->subject->initClass($search);

        return $this->subject->executeCustomSearch();
    }
}
