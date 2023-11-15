<?php

namespace Core\Main\Factories\Middleware;

use Core\Main\Factories\Repository\AccountRepositoryFactory;
use Core\Ui\Api\MiddlewareInterface;
use Core\Ui\Api\Middlewares\AuthMiddleware;

class AuthMiddlewareFactory
{
    public static function create(): MiddlewareInterface
    {
        return new AuthMiddleware(
            accountRepository: AccountRepositoryFactory::create()
        );
    }
}