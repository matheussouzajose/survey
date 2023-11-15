<?php

namespace Core\Main\Factories\UseCase;

use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Infrastructure\Cryptography\JwtAdapter\JwtAdapter;
use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;
use Core\Infrastructure\Validator\SignInValidator;
use Core\Main\Factories\Repository\AccountRepositoryFactory;

class SignInUseCaseFactory
{
    public static function create(): SignInUseCase
    {
        return new SignInUseCase(
            validator: new SignInValidator(),
            accountRepository: AccountRepositoryFactory::create(),
            hasher: new PasswordAdapter(),
            encrypter: new JwtAdapter(secretKey: getenv('JWT_SECRET'))
        );
    }
}