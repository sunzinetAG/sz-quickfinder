<?php
namespace Sunzinet\SzIndexedSearch\Domain\Model;

    /**
     * Description of the phpfile 'Pages.php'
     *
     * @author Dennis Römmich <dennis@roemmich.eu>
     * @copyright Copyright belongs to the respective authors
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */

/**
 * Class File
 *
 * @package Sunzinet\SzIndexedSearch\Domain\Model
 */
class File extends AbstractSearch
{
    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * uidForeign
     *
     * @var int
     */
    protected $uidForeign;

    /**
     * tablenames
     *
     * @var string
     */
    protected $tablenames;

    /**
     * fieldname
     *
     * @var string
     */
    protected $fieldname;


    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the uidForeign
     *
     * @return int $uidForeign
     */
    public function getUidForeign()
    {
        return $this->uidForeign;
    }

    /**
     * @return string
     */
    public function getTablenames()
    {
        return $this->tablenames;
    }

    /**
     * @param string $tablenames
     */
    public function setTablenames($tablenames)
    {
        $this->tablenames = $tablenames;
    }

    /**
     * @return string
     */
    public function getFieldname()
    {
        return $this->fieldname;
    }

    /**
     * @param string $fieldname
     */
    public function setFieldname($fieldname)
    {
        $this->fieldname = $fieldname;
    }
}
