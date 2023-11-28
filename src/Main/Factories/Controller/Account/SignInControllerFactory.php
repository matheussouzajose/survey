<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Account;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Main\Factories\UseCase\Account\SignInUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignInController;
use Core\Ui\Api\ControllerInterface;

class SignInControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(
            controller: new SignInController(useCase: SignInUseCaseFactory::create()),
            logRepositor: new LogMongoRepository()
        );
    }
}