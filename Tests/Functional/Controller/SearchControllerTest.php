<?php

namespace Sunzinet\SzQuickfinder\Tests\Controller;

/**
 * Class SearchControllerTest
 *
 * @package Sunzinet\SzQuickfinder\Tests\Controller
 */
class SearchControllerTest extends \Nimut\TestingFramework\TestCase\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/sz_quickfinder',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->importDataSet('ntf://Database/pages.xml');
        $this->setUpFrontendRootPage(1, [
            'EXT:sz_quickfinder/Tests/Functional/Fixtures/TypoScript/page.ts',
            'EXT:sz_quickfinder/Configuration/TypoScript/setup.txt',
        ]);
    }

    /**
     * @test
     */
    public function frontendRequest()
    {
        $response = $this->getFrontendResponse(1);
        $this->assertSame('success', $response->getStatus());
    }

    /**
     * @test
     */
    public function formIsVisibleIfTypoScriptIsIncluded()
    {
        $response = $this->getFrontendResponse(1);
        $this->assertContains('<form action="" method="post">', $response->getContent());
        $this->assertContains('<button type="submit">Suchen</button>', $response->getContent());
        $this->assertContains('<div class="tx-quickfinder-searchbox-results"></div>', $response->getContent());
    }
}
