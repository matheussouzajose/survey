<?php

namespace Core\Domain\Account\Repository;

use Core\Domain\Account\Entity\Account;

interface AccountRepositoryInterface
{
    public function checkByEmail(string $email): bool;
    public function add(Account $entity): Account;
}