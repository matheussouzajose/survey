<?php

declare(strict_types=1);

namespace Core\Main\Factories\Middleware;

use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;
use Core\Ui\Api\MiddlewareInterface;
use Core\Ui\Api\Middlewares\AuthMiddleware;

class AuthMiddlewareFactory
{
    public static function create(): MiddlewareInterface
    {
        return new AuthMiddleware(
            accountRepository: AccountMongoRepositoryFactory::create()
        );
    }
}