<?php
namespace Sunzinet\SzQuickfinder\Domain\Model;

/**
 * Class User
 * @package Sunzinet\SzQuickfinder\Domain\Model
 */
class User extends AbstractSearch
{
    /**
     * @var string $username
     */
    protected $username;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
