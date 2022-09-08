<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Settings;

use Sunzinet\SzQuickfinder\TyposcriptSettings as TyposcriptSettingsInterface;

class TyposcriptSettings implements TyposcriptSettingsInterface
{
    /**
     * @var string
     */
    protected $class = '';

    /**
     * @var string
     */
    protected $regEx = '%|%';

    /**
     * @var int
     */
    protected $maxResults = 3;

    /**
     * @var bool
     */
    protected $includeNavHiddenPages = false;

    /**
     * @var array
     */
    protected $searchFields = ['title'];

    /**
     * Necessary for document search
     *
     * @var array
     */
    protected $allowedFieldnames = ['media'];

    /**
     * @var string
     */
    protected $searchString = '';

    /**
     * @var string
     */
    protected $orderBy = 'uid';

    /**
     * @var bool
     */
    protected $ascending = true;

    /**
     * @var string
     */
    protected $script = '';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $blacklistPid = [];

    /**
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        foreach ($settings as $propertyName => $value) {
            $this->setProperty($propertyName, $value);
        }
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegEx(): string
    {
        return $this->regEx;
    }

    /**
     * @param string $regEx
     * @return self
     */
    public function setRegEx(string $regEx): self
    {
        $this->regEx = $regEx;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    /**
     * @param int $maxResults
     * @return self
     */
    public function setMaxResults(int $maxResults): self
    {
        $this->maxResults = $maxResults;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIncludeNavHiddenPages(): bool
    {
        return $this->includeNavHiddenPages;
    }

    /**
     * @param int|bool $includeNavHiddenPages
     * @return self
     */
    public function setIncludeNavHiddenPages($includeNavHiddenPages): self
    {
        $this->includeNavHiddenPages = (bool) $includeNavHiddenPages;
        return $this;
    }

    /**
     * @return iterable
     */
    public function getSearchFields(): iterable
    {
        return $this->searchFields;
    }

    /**
     * @param iterable $searchFields
     * @return self
     */
    public function setSearchFields(iterable $searchFields): self
    {
        $this->searchFields = $searchFields;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedFieldnames(): array
    {
        return $this->allowedFieldnames;
    }

    /**
     * @param array $allowedFieldnames
     * @return self
     */
    public function setAllowedFieldnames(array $allowedFieldnames): self
    {
        $this->allowedFieldnames = $allowedFieldnames;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchString(): string
    {
        return $this->searchString;
    }

    /**
     * @param string $searchString
     * @return self
     */
    public function setSearchString(string $searchString): self
    {
        $this->searchString = $searchString;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     * @return self
     */
    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAscending(): bool
    {
        return $this->ascending;
    }

    /**
     * @param bool $ascending
     * @return self
     */
    public function setAscending(bool $ascending): self
    {
        $this->ascending = $ascending;
        return $this;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    /**
     * @param string $script
     * @return self
     */
    public function setScript(string $script): self
    {
        $this->script = $script;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return self
     */
    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getBlacklistPid(): array
    {
        return $this->blacklistPid;
    }

    /**
     * @param array $blacklistPid
     * @return self
     */
    public function setBlacklistPid(array $blacklistPid): self
    {
        $this->blacklistPid = $blacklistPid;
        return $this;
    }

    /**
     * @param string $propertyName
     * @param mixed $value
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\Exception\NonExistentPropertyException
     * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
     * @return void
     */
    public function setProperty(string $propertyName, $value): void
    {
        if (! $this->hasProperty($propertyName)) {
            throw new \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\Exception\NonExistentPropertyException(
                sprintf('Property "%s" does not exist in class "%s".', $propertyName, __CLASS__),
                1442413257
            );
        }

        $method = 'set' . ucfirst($propertyName);
        $value = self::convert(gettype($this->{$propertyName}), $value);
        if (! method_exists($this, $method)) {
            throw new \BadMethodCallException(
                sprintf('Method "%s" does not exist in class "%s".', $method, __CLASS__),
                1456819227
            );
        }

        $this->$method($value);
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    protected function hasProperty(string $propertyName): bool
    {
        return property_exists(self::class, $propertyName);
    }

    /**
     * @param string $type
     * @param mixed $var
     * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
     * @return array|bool|int|string
     */
    protected static function convert(string $type, $var)
    {
        switch ($type) {
            case 'string':
                return (string) $var;
            case 'integer':
                return (int) $var;
            case 'boolean':
                return filter_var($var, FILTER_VALIDATE_BOOLEAN);
            case 'array':
                if (is_array($var)) {
                    return $var;
                }
                return array_map('trim', explode(',', (string) $var));
            default:
                throw new \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException(
                    'Unsupported type',
                    1442418939
                );
        }
    }
}
