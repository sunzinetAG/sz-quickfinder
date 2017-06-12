<?php
namespace Sunzinet\SzQuickfinder\Controller;

use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\Searchable;
use Sunzinet\SzQuickfinder\SearchResult;
use Sunzinet\SzQuickfinder\Settings\TyposcriptSettings;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class SearchController
 *
 * @package Sunzinet\SzQuickfinder\Controller
 */
class SearchController extends ActionController
{
    /**
     * searchRepository
     *
     * @var \Sunzinet\SzQuickfinder\Domain\Repository\SearchRepository
     * @inject
     */
    protected $searchRepository;

    /**
     * Only show the SearchForm
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('searchPid', $this->settings['searchPid']);
    }

    /**
     * autocomplete action
     *
     * @param string $searchString The string
     * @return void
     */
    public function autocompleteAction($searchString)
    {
        $customSearchArray = $this->settings['customSearch'];

        $results = [];

        foreach ($customSearchArray as $sectionName => $customSearch) {
            $search = $this->objectManager->get($customSearch['class']);
            if (!($search instanceof SearchResult)) {
                throw new \UnexpectedValueException(
                    get_class($search) . ' must implement interface ' . SearchResult::class,
                    1497260885905
                );
            }
            /** @var TyposcriptSettings $settings */
            $settings = $this->objectManager->get(
                TyposcriptSettings::class,
                array_merge($this->settings['global'], $customSearch)
            );
            $settings->setProperty('searchString', $searchString);

            $search->injectSettings($settings);
            $repository = $this->getRepository($customSearch);

            if (!($search instanceof Search)) {
                throw new \UnexpectedValueException(
                    get_class($repository) . ' must implement interface ' . Search::class,
                    1469445839
                );
            }

            $repository->initClass($search);
            $results[$sectionName] = $repository->executeCustomSearch();
            $repository->reset();
        }

        $this->view->assign('searchString', $searchString);
        $this->view->assign('results', $results);
    }

    /**
     * @param array $customSearch
     * @return Searchable
     */
    protected function getRepository($customSearch)
    {
        /** @var Searchable $repository */
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder'][$customSearch['class']]['repository'])) {
            $repository = $this->objectManager->get(
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder'][$customSearch['class']]['repository']
            );
        } else {
            $repository = $this->objectManager->get(
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sz_quickfinder']['default']['repository']
            );
        }

        if (!($repository instanceof Searchable)) {
            throw new \UnexpectedValueException(
                get_class($repository) . ' must implement interface ' . Searchable::class,
                1469445839
            );
        }

        return $repository;
    }

    /**
     * Goes forward to IndexedSearch
     *
     * @param string $string The string
     * @return void
     */
    public function searchAction($string)
    {
        $params = ['search' => ['searchWords' => $string, 'searchParams' => $string, 'sword' => $string]];
        $this->forward('search', 'Search', 'IndexedSearch', $params);
    }
}
