<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Account;

use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Domain\Account\Event\AccountAuthenticatedEvent;
use Core\Domain\Account\Event\Handler\SaveLogWhenAccountLoggedIn;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Infrastructure\Cryptography\JwtAdapter\JwtAdapter;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Infrastructure\Validator\SignInValidator;
use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;

class SignInUseCaseFactory
{
    public static function create(): SignInUseCase
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->register(
            eventName: AccountAuthenticatedEvent::class,
            eventHandler: new SaveLogWhenAccountLoggedIn(
                logRepository: new LogMongoRepository()
            )
        );

        return new SignInUseCase(
            validator: new SignInValidator(),
            accountRepository: AccountMongoRepositoryFactory::create(),
            hasher: new PasswordAdapter(),
            encrypter: new JwtAdapter(secretKey: getenv('JWT_SECRET')),
            eventDispatcher: $eventDispatcher
        );
    }
}