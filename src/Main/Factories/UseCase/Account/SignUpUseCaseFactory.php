<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Account;

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Event\AccountCreatedEvent;
use Core\Domain\Account\Event\Handler\SendEmailWhenAccountIsCreated;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;

class SignUpUseCaseFactory
{
    public function create(): SignUpUseCase
    {
        return new SignUpUseCase(
            accountRepository: (new AccountMongoRepositoryFactory)->create(),
            hasher: new PasswordAdapter(),
            eventDispatcher: $this->registerEvents()
        );
    }

    private function registerEvents(): EventDispatcher
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->register(AccountCreatedEvent::class, new SendEmailWhenAccountIsCreated());
        return $eventDispatcher;
    }
}