<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class File extends AbstractSearch
{
    /**
     * @var string
     */
    protected string $title = '';

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var int
     */
    protected int $uidForeign = 0;

    /**
     * @var string
     */
    protected string $tablenames = '';

    /**
     * @var string
     */
    protected string $fieldname = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getUidForeign(): int
    {
        return $this->uidForeign;
    }

    /**
     * @return string
     */
    public function getTablenames(): string
    {
        return $this->tablenames;
    }

    /**
     * @param string
     * @return void
     */
    public function setTablenames(string $tablenames): void
    {
        $this->tablenames = $tablenames;
    }

    /**
     * @return string
     */
    public function getFieldname(): string
    {
        return $this->fieldname;
    }

    /**
     * @param string
     * @return void
     */
    public function setFieldname(string $fieldname): void
    {
        $this->fieldname = $fieldname;
    }
}
