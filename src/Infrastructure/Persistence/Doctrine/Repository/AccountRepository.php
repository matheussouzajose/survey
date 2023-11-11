<?php

namespace Core\Infrastructure\Persistence\Doctrine\Repository;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Repository\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    public function checkByEmail(string $email): string
    {
        // TODO: Implement checkByEmail() method.
    }

    public function add(Account $account): Account
    {
        // TODO: Implement add() method.
    }
}