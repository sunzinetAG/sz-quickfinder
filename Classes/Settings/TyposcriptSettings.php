<?php
namespace Sunzinet\SzIndexedSearch\Settings;

/**
 * Description of the class 'TyposcriptSettings.php'
 *
 * @author Dennis Römmich <dennis@roemmich.eu>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
use Sunzinet\SzIndexedSearch\Utility\SanitizeUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class TyposcriptSettings
 *
 * @package Sunzinet\SzIndexedSearch\Settings
 */
class TyposcriptSettings implements TyposcriptSettingsInterface
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
     * searchString
     *
     * @var SanitizeUtility $searchString
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
     * @param SanitizeUtility $searchString
     * @return $this
     */
    public function setSearchString($searchString)
    {
        $this->searchString = GeneralUtility::makeInstance(SanitizeUtility::class, $searchString);

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
