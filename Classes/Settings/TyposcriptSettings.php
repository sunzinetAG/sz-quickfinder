<?php
namespace Sunzinet\SzQuickfinder\Settings;

/**
 * Class TyposcriptSettings
 * @package Sunzinet\SzQuickfinder\Settings
 */
class TyposcriptSettings implements \Sunzinet\SzQuickfinder\TyposcriptSettings
{
    /**
     * class
     *
     * @var string $class
     */
    protected $class = '';

    /**
     * regEx
     *
     * @var string $regEx
     */
    protected $regEx = '%|%';

    /**
     * maxResults
     *
     * @var int $maxResults
     */
    protected $maxResults = 3;

    /**
     * includeNavHiddenPages
     *
     * @var bool $includeNavHiddenPages
     */
    protected $includeNavHiddenPages = false;

    /**
     * searchFields
     *
     * @var array $searchFields
     */
    protected $searchFields = ['title'];

    /**
     * allowedFieldnames needed for document search
     *
     * @var array $allowedFieldnames
     */
    protected $allowedFieldnames = ['media'];

    /**
     * searchString
     *
     * @var string $searchString
     */
    protected $searchString = '';

    /**
     * orderBy
     *
     * @var string $orderBy
     */
    protected $orderBy = 'uid';

    /**
     * ascending
     *
     * @var bool $ascending
     */
    protected $ascending = true;

    /**
     * script
     *
     * @var string $script
     */
    protected $script = '';

    /**
     * params
     *
     * @var array $params
     */
    protected $params = [];

    /**
     * blacklistPid
     *
     * @var array $blacklistPid
     */
    protected $blacklistPid = [];

    /**
     * TyposcriptSettings constructor.
     *
     * @param array $settings
     * @throws \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException
     */
    public function __construct(array $settings)
    {
        foreach ($settings as $propertyName => $value) {
            $this->setProperty($propertyName, $value);
        }
    }

    /**
     * getClass
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * setModel
     *
     * @param string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * getRegEx
     *
     * @return string
     */
    public function getRegEx()
    {
        return $this->regEx;
    }

    /**
     * setRegEx
     *
     * @param string $regEx
     * @return $this
     */
    public function setRegEx($regEx)
    {
        $this->regEx = $regEx;

        return $this;
    }

    /**
     * getMaxResults
     *
     * @return int
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * setMaxResults
     *
     * @param int $maxResults
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    /**
     * getIncludeNavHiddenPages
     *
     * @return int
     */
    public function getIncludeNavHiddenPages()
    {
        return $this->includeNavHiddenPages;
    }

    /**
     * setIncludeNavHiddenPages
     *
     * @param int $includeNavHiddenPages
     * @return $this
     */
    public function setIncludeNavHiddenPages($includeNavHiddenPages)
    {
        $this->includeNavHiddenPages = $includeNavHiddenPages;

        return $this;
    }

    /**
     * getSearchfields
     *
     * @return array
     */
    public function getSearchFields()
    {
        return $this->searchFields;
    }

    /**
     * setSearchFields
     *
     * @param [] $searchFields
     * @return $this
     */
    public function setSearchFields($searchFields)
    {
        $this->searchFields = $searchFields;

        return $this;
    }

    /**
     * getAllowedFieldnames
     *
     * @return array
     */
    public function getAllowedFieldnames()
    {
        return $this->allowedFieldnames;
    }

    /**
     * setSearchFields
     *
     * @param [] $searchFields
     * @return $this
     */
    public function setAllowedFieldnames($allowedFieldnames)
    {
        $this->allowedFieldnames = $allowedFieldnames;

        return $this;
    }

    /**
     * getSearchString
     *
     * @return string
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * setSearchString
     *
     * @param string $searchString
     * @return $this
     */
    public function setSearchString($searchString)
    {
        $this->searchString = $searchString;

        return $this;
    }

    /**
     * getOrderBy
     *
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * setOrderBy
     *
     * @param string $orderBy
     * @return $this
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * getAscending
     *
     * @return boolean
     */
    public function getAscending()
    {
        return $this->ascending;
    }

    /**
     * setAscending
     *
     * @param boolean $ascending
     * @return $this
     */
    public function setAscending($ascending)
    {
        $this->ascending = $ascending;

        return $this;
    }

    /**
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param string $script
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams($params)
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
     */
    public function setBlacklistPid(array $blacklistPid)
    {
        $this->blacklistPid = $blacklistPid;
    }

    /**
     * setProperty
     *
     * @param string $propertyName
     * @param mixed $value
     * @throws \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException
     * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
     * @return void
     */
    public function setProperty($propertyName, $value)
    {
        if (!$this->hasProperty($propertyName)) {
            throw new \TYPO3\CMS\Extbase\Property\Exception\InvalidPropertyException(
                'Property ' . $propertyName . ' does not Exist in ' . __CLASS__,
                1442413257
            );
        }
        $method = 'set' . ucfirst($propertyName);
        $value = self::convert(gettype($this->{$propertyName}), $value);
        if (!method_exists($this, $method)) {
            throw new \BadMethodCallException(
                'Method ' . $method . ' does not Exist in ' . __CLASS__,
                1456819227
            );
        }

        call_user_func([$this, $method], $value);
    }

    /**
     * hasProperty
     *
     * @param string $propertyName
     * @return bool
     */
    protected function hasProperty($propertyName)
    {
        return property_exists(self::class, $propertyName);
    }

    /**
     * convert
     *
     * @param mixed $type
     * @param mixed $var
     * @return array|bool|int|string
     * @throws \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException
     */
    protected static function convert($type, $var)
    {
        switch ($type) {
            case 'string':
                return (string)$var;
            case 'integer':
                return (int)$var;
            case 'boolean':
                return filter_var($var, FILTER_VALIDATE_BOOLEAN);
            case 'array':
                if (is_array($var)) {
                    return $var;
                }
                return array_map('trim', explode(',', $var));
            default:
                throw new \TYPO3\CMS\Extbase\Utility\Exception\InvalidTypeException(
                    'Unsupported type',
                    1442418939
                );
        }
    }
}
