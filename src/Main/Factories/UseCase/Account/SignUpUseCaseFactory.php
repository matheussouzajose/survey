<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Account;

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Persistence\Doctrine\Repository\DbTransaction;
use Core\Infrastructure\Validator\SignUpValidator;
use Core\Main\Factories\Repository\AccountRepositoryFactory;

class SignUpUseCaseFactory
{
    public static function create(): SignUpUseCase
    {
        return new SignUpUseCase(
            accountRepository: AccountRepositoryFactory::create(),
            hasher: new PasswordAdapter(),
            dbTransaction: new DbTransaction(),
            eventDispatcher: new EventDispatcher(),
            validator: new SignUpValidator()
        );
    }
}