<?php
declare(strict_types = 1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class File
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class File extends AbstractSearch
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var int $uidForeign
     */
    protected $uidForeign;

    /**
     * @var string $tablenames
     */
    protected $tablenames;

    /**
     * @var string $fieldname
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
