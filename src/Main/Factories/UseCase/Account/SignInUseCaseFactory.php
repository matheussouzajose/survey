<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Account;

use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Infrastructure\Cryptography\JwtAdapter\JwtAdapter;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Validator\SignInValidator;
use Core\Main\Factories\Repository\MongoDb\AccountMongoRepositoryFactory;

class SignInUseCaseFactory
{
    public static function create(): SignInUseCase
    {
        return new SignInUseCase(
            validator: new SignInValidator(),
            accountRepository: AccountMongoRepositoryFactory::create(),
            hasher: new PasswordAdapter(),
            encrypter: new JwtAdapter(secretKey: getenv('JWT_SECRET'))
        );
    }
}