<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Repository;

use Sunzinet\SzQuickfinder\Domain\Model\File;
use Sunzinet\SzQuickfinder\Domain\Model\Page;
use Sunzinet\SzQuickfinder\Domain\Model\PageLanguageOverlay;
use Sunzinet\SzQuickfinder\Search;
use Sunzinet\SzQuickfinder\Searchable;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use Sunzinet\SzQuickfinder\Service\PidListService;

class SearchRepository extends Repository implements Searchable
{
    /**
     * @var string
     */
    public $className = '';

    /**
     * @var Search
     */
    protected $class;

    /**
     * @var array
     */
    protected $logicalAnd = [];

    /**
     * @var array
     */
    protected $logicalOr = [];

    /**
     * @var array
     */
    protected $constraints = [];

    /**
     * @var QueryInterface
     */
    protected $query;

    /**
     * @param Search $class
     * @return void
     */
    public function initClass(Search $class): void
    {
        $this->class = $class;
        $this->className = $class->getSettings()->getClass();
        if (! self::useOldLanguageHandling()) {
            return;
        }

        if ($class->getSettings()->getClass() === Page::class and (int) GeneralUtility::_GP('L') !== 0) {
            $this->className = PageLanguageOverlay::class;
        }
    }

    /**
     * @return void
     */
    public function initSettings(): void
    {
        $this->query = $this->persistenceManager->createQueryForType($this->className);
        $this->setQuerySettings();
        $this->setSearchFields();
        $this->setCustomEnableFields(
            $this->query->getQuerySettings()->getStoragePageIds(),
            $this->class->getSettings()->getBlacklistPid()
        );

        $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
        $signalSlotDispatcher->dispatch(
            __CLASS__,
            'afterInitSettings',
            [&$this->logicalAnd, $this->className, $this->query]
        );

        $constraints[] = $this->query->logicalAnd($this->logicalAnd);
        if ($this->logicalOr !== []) {
            $constraints[] = $this->query->logicalOr($this->logicalOr);
        }

        $this->query->matching($this->query->logicalAnd($constraints));
    }

    /**
     * @return QueryResultInterface
     */
    public function executeCustomSearch(): QueryResultInterface
    {
        $this->initSettings();
        return $this->query->execute();
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->query = null;
        $this->settings = null;
        $this->logicalAnd = [];
        $this->logicalOr = [];
        $this->constraints = [];
    }

    /**
     * Fills logicalAnd and logicalOr for the query
     *
     * @param iterable $storagePageIds
     * @param iterable $blockedPageIds
     * @return void
     */
    protected function setCustomEnableFields(iterable $storagePageIds, iterable $blockedPageIds): void
    {
        switch ($this->className) {
            case Page::class:
                if (! $this->class->getSettings()->getIncludeNavHiddenPages()) {
                    $this->logicalAnd[] = $this->query->equals(
                        'nav_hide',
                        $this->class->getSettings()->getIncludeNavHiddenPages()
                    );
                }
                $this->logicalAnd[] = $this->query->logicalNot($this->query->equals('doktype', 254));
                $this->logicalAnd[] = $this->query->logicalNot($this->query->equals('doktype', 4));
                break;
            case File::class:
                $this->logicalAnd[] = $this->query->in(
                    'fieldname',
                    $this->class->getSettings()->getAllowedFieldnames()
                );
                break;
            default:
                break;
        }

        $allowedPageIds = GeneralUtility::makeInstance(PidListService::class)->generate(
            $storagePageIds,
            $blockedPageIds
        );
        if ($allowedPageIds !== []) {
            $this->logicalOr[] = $this->query->in('pid', $allowedPageIds);
        }

        $this->logicalAnd[] = $this->query->logicalOr($this->constraints);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @return void
     */
    protected function setQuerySettings(): void
    {
        $this->query->setOrderings([
            $this->class->getSettings()->getOrderBy() =>
                $this->class->getSettings()->getAscending()
                    ? QueryInterface::ORDER_ASCENDING
                    : QueryInterface::ORDER_DESCENDING,
        ]);

        // @Todo: Language not working correctly yet
        $this->query->getQuerySettings()
            ->setRespectStoragePage(false)
            ->setRespectSysLanguage(true);

        if (self::useOldLanguageHandling()) {
            $this->query->getQuerySettings()->setLanguageUid((int) GeneralUtility::_GP('L'));
        }
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Security\Exception
     * @return void
     */
    private function setSearchFields(): void
    {
        $searchString = str_replace(
            '|',
            $this->class->getSettings()->getSearchString(),
            $this->class->getSettings()->getRegEx()
        );
        foreach ($this->class->getSettings()->getSearchFields() as $propertyName) {
            $this->constraints[] = $this->query->like(
                $propertyName,
                $searchString
            );
        }
    }

    /**
     * @return bool
     */
    private static function useOldLanguageHandling(): bool
    {
        return GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() < 10;
    }
}
