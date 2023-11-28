<?php

namespace Core\Main\Factories\Repository\MongoDb;

use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Infrastructure\Persistence\MongoDb\Repository\AccountMongoRepository;

class AccountMongoRepositoryFactory
{
    public static function create(): AccountRepositoryInterface
    {
        return new AccountMongoRepository();
    }
}