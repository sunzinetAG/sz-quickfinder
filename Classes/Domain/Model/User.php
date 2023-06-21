<?php

declare(strict_types=1);

namespace Sunzinet\SzQuickfinder\Domain\Model;

class User extends AbstractSearch
{
    /**
     * @var string
     */
    protected string $username = '';

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
