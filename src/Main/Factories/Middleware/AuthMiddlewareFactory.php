<?php

declare(strict_types=1);

namespace Core\Main\Factories\Middleware;

use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;
use Core\Ui\Api\MiddlewareInterface;
use Core\Ui\Api\Middlewares\AuthMiddleware;

class AuthMiddlewareFactory
{
    public function create(): MiddlewareInterface
    {
        return new AuthMiddleware(
            accountRepository: (new AccountMongoRepositoryFactory)->create()
        );
    }
}