<?php

declare(strict_types=1);

namespace Core\Main\Factories\Repository;

use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Account;
use Core\Infrastructure\Persistence\Doctrine\Repository\AccountRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class AccountRepositoryFactory
{
    public static function create(): AccountRepositoryInterface
    {
        return new AccountRepository(
            em: EntityManagerHelperSingleton::getInstance(),
            class: new ClassMetadata(Account::class)
        );
    }
}