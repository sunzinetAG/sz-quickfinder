<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Controller;

use Psr\Http\Message\ResponseInterface;
use Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository;
use Sunzinet\SzQuickfinder\Domain\Repository\SuggestionRepository;
use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\Searchable;
use Sunzinet\SzQuickfinder\SearchResult;
use Sunzinet\SzQuickfinder\Settings\TyposcriptSettings;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SearchController extends ActionController
{
    /**
     * @var SearchRepository
     */
    protected $searchRepository;

    /**
     * @var SuggestionRepository
     */
    protected SuggestionRepository $suggestionRepository;

    /**
     * @param SearchRepository $searchRepository
     * @param SuggestionRepository $suggestionRepository
     */
    public function __construct(SearchRepository $searchRepository, SuggestionRepository $suggestionRepository)
    {
        $this->searchRepository = $searchRepository;
        $this->suggestionRepository = $suggestionRepository;
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $this->view->assignMultiple([
            'searchPid' => $this->settings['searchPid'],
            'suggestions' => $this->suggestionRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }

    /**
     * @param string $searchString
     * @return ResponseInterface
     */
    public function autocompleteAction(string $searchString): ResponseInterface
    {
        $results = [];
        $resultCount = [];
        $customSearchArray = $this->settings['customSearch'];
        foreach ($customSearchArray as $sectionName => $customSearch) {
            $search = GeneralUtility::makeInstance($customSearch['class']);
            if (! $search instanceof SearchResult) {
                throw new \UnexpectedValueException(
                    sprintf('Class "%s" must implement interface "%s".', get_class($search), SearchResult::class),
                    1497260885905
                );
            }

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
            $results[$sectionName] = $repository->executeCustomSearch();

            $resultCount[$sectionName] = $results[$sectionName]->count();
            if($search->getSettings()->getDisplayMaxResults()) {
                $results[$sectionName] = array_slice($results[$sectionName]->toArray(), 0, $search->getSettings()->getDisplayMaxResults());
            }

            $repository->reset();
        }

        $this->view->assignMultiple([
            'searchString' => $searchString,
            'results' => $results,
            'resultCount' => $resultCount,
            'resultCountOverall' => array_sum($resultCount),
            'suggestions' => $this->suggestionRepository->findAll(),
        ]);
        return $this->htmlResponse();
    }

    /**
     * Forwards to EXT:indexed_search
     *
     * @param string $string
     * @return ResponseInterface
     */
    public function searchAction(string $string): ResponseInterface
    {
        $params = ['search' => ['searchWords' => $string, 'searchParams' => $string, 'sword' => $string]];
        return (new ForwardResponse('search'))
            ->withControllerName('Search')
            ->withExtensionName('IndexedSearch')
            ->withArguments($params);
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
