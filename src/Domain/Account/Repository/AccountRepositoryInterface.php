<?php

namespace Core\Domain\Account\Repository;

use Core\Domain\Account\Entity\Account;

interface AccountRepositoryInterface
{
    public function checkByEmail(string $email): string;
    public function add(Account $account): Account;
}