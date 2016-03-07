<?php
namespace Sunzinet\SzIndexedSearch\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Dennis Römmich <dennis.roemmich@sunzinet.com>, sunzinet AG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Sunzinet\SzIndexedSearch\Settings\TyposcriptSettings;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class SearchController
 *
 * @package Sunzinet\SzIndexedSearch\Controller
 */
class SearchController extends ActionController
{
    /**
     * searchRepository
     *
     * @var \Sunzinet\SzIndexedSearch\Domain\Repository\SearchRepository
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

        $results = array();

        foreach ($customSearchArray as $sectionName => $customSearch) {
            /** @var TyposcriptSettings $settings */
            $settings = $this->objectManager->get(
                TyposcriptSettings::class,
                array_merge($this->settings['global'], $customSearch)
            );
            $settings->setProperty('searchString', $searchString);

            $this->searchRepository->prepareCustomSearch($settings);
            $results[$sectionName] = $this->searchRepository->executeCustomSearch();

            $this->searchRepository->reset();
        }

        $this->view->assign('searchString', $searchString);
        $this->view->assign('results', $results);
    }

    /**
     * Goes forward to IndexedSearch
     *
     * @param string $string The string
     * @return void
     */
    public function searchAction($string)
    {
        $params = array('search' => array('searchWords' => $string, 'searchParams' => $string, 'sword' => $string));
        $this->forward('search', 'Search', 'IndexedSearch', $params);
    }
}
