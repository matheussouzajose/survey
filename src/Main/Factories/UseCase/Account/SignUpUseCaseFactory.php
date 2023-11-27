<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Account;

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Event\AccountCreatedEvent;
use Core\Domain\Account\Event\Handler\SendEmailWhenAccountIsCreated;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Validator\SignUpValidator;
use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;

class SignUpUseCaseFactory
{
    public static function create(): SignUpUseCase
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->register(AccountCreatedEvent::class, new SendEmailWhenAccountIsCreated());

        return new SignUpUseCase(
            accountRepository: AccountMongoRepositoryFactory::create(),
            hasher: new PasswordAdapter(),
            eventDispatcher: $eventDispatcher,
            validator: new SignUpValidator()
        );
    }
}