<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Controller;

use Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository;
use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\Searchable;
use Sunzinet\SzQuickfinder\SearchResult;
use Sunzinet\SzQuickfinder\Settings\TyposcriptSettings;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class SearchController extends ActionController
{
    /**
     * @var Search
     */
    private static $searchModelClasses;

    /**
     * @var SearchRepository
     */
    protected $searchRepository;

    /**
     * @param SearchRepository $searchRepository
     */
    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    /**
     * @return void
     */
    public function indexAction(): void
    {
        $this->view->assign('searchPid', $this->settings['searchPid']);
    }

    /**
     * @param string $searchString
     * @return void
     */
    public function autocompleteAction(string $searchString): void
    {
        $results = [];
        $resultCount = [];
        $customSearchArray = $this->settings['customSearch'];
        foreach ($customSearchArray as $sectionName => $customSearch) {
            $search = $this->getSearchModelObject($customSearch['class']);

            $results[$sectionName] = $this->performSearch($searchString, $customSearch);

            $resultCount[$sectionName] = $results[$sectionName]->count();

            $results[$sectionName] = array_slice($results[$sectionName]->toArray(), 0, $search->getSettings()->getMaxResults());
        }

        $this->view->assignMultiple([
            'searchString' => $searchString,
            'results' => $results,
            'resultCount' => $resultCount,
        ]);
    }

    public function listAction(string $searchString = ''): void
    {
        if (empty($searchString)) {
            return;
        }

        $results = [];
        $resultCount = [];
        $customSearchArray = $this->settings['customSearch'];
        foreach ($customSearchArray as $sectionName => $customSearch) {
            $search = $this->getSearchModelObject($customSearch['class']);

            $results[$sectionName] = $this->performSearch($searchString, $customSearch);

            $results[$sectionName] = array_slice($results[$sectionName]->toArray(), 0, $search->getSettings()->getMaxListResults());

            $resultCount[$sectionName] = count($results[$sectionName]);
        }

        $this->view->assignMultiple([
            'searchString' => $searchString,
            'results' => $results,
            'resultCount' => $resultCount,
            'totalResults' => array_sum($resultCount)
        ]);
    }

    private function getSearchModelObject(string $className)
    {
        if (isset(static::$searchModelClasses[$className])) {
            return static::$searchModelClasses[$className];
        }

        static::$searchModelClasses[$className] = GeneralUtility::makeInstance($className);

        if (! static::$searchModelClasses[$className] instanceof SearchResult) {
            throw new \UnexpectedValueException(
                sprintf('Class "%s" must implement interface "%s".', get_class(static::$searchModelClasses[$className]), SearchResult::class),
                1497260885905
            );
        }

        return static::$searchModelClasses[$className];
    }

    private function performSearch(string $searchString, array $customSearch): QueryResultInterface
    {
        $search = $this->getSearchModelObject($customSearch['class']);

        /** @var TyposcriptSettings $settings */
        $settings = GeneralUtility::makeInstance(
            TyposcriptSettings::class,
            array_merge($this->settings['global'], $customSearch)
        );
        $settings->setProperty('searchString', $searchString);

        $search->injectSettings($settings);
        $repository = $this->getRepository($customSearch);

        if (! $search instanceof Search) {
            throw new \UnexpectedValueException(
                get_class($repository) . ' must implement interface ' . Search::class,
                1469445839
            );
        }

        $repository->initClass($search);
        $results = $repository->executeCustomSearch();
        $repository->reset();

        return $results;
    }

    /**
     * Forwards to EXT:indexed_search
     *
     * @param string $string
     * @return void
     */
    public function searchAction(string $string): void
    {
        $params = ['search' => ['searchWords' => $string, 'searchParams' => $string, 'sword' => $string]];
        $this->forward('search', 'Search', 'IndexedSearch', $params);
    }

    /**
     * @param array $customSearch
     * @return Searchable
     */
    protected function getRepository(array $customSearch): Searchable
    {
        $class = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder'][$customSearch['class']]['repository']
            ?? $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository'];
        $repository = GeneralUtility::makeInstance($class);
        if (! $repository instanceof Searchable) {
            throw new \UnexpectedValueException(
                sprintf('Class "%s" must implement interface "%s".', get_class($repository), Searchable::class),
                1469445839
            );
        }

        return $repository;
    }
}
