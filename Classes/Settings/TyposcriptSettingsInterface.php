<?php
namespace Sunzinet\SzIndexedSearch\Settings;

    /**
     * Description of the interface 'TyposcriptSettingsInterface.php'
     *
     * @author Dennis Römmich <dennis@roemmich.eu>
     * @copyright Copyright belongs to the respective authors
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */

/**
 * Interface TyposcriptSettingsInterface
 *
 * @package Sunzinet\SzIndexedSearch\Provider
 */
interface TyposcriptSettingsInterface
{
    /**
     * getClass
     *
     * @return string
     */
    public function getClass();

    /**
     * getRegEx
     *
     * @return string
     */
    public function getRegEx();

    /**
     * getMaxResults
     *
     * @return int
     */
    public function getMaxResults();

    /**
     * getIncludeNavHiddenPages
     *
     * @return int
     */
    public function getIncludeNavHiddenPages();

    /**
     * getSearchfields
     *
     * @return string
     */
    public function getSearchfields();

    /**
     * getAllowedFieldnames
     *
     * @return string
     */
    public function getAllowedFieldnames();

    /**
     * getSearchString
     *
     * @return string
     */
    public function getSearchString();

    /**
     * getOrderBy
     *
     * @return string
     */
    public function getOrderBy();

    /**
     * getScript
     *
     * @return string
     */
    public function getScript();

    /**
     * getParams
     *
     * @return array
     */
    public function getParams();

    /**
     * setProperty
     *
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    public function setProperty($propertyName, $value);
}
