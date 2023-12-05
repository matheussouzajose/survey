<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Account;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Infrastructure\Validation\Account\SignInValidation;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Main\Factories\UseCase\Account\SignInUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignInController;
use Core\Ui\Api\ControllerInterface;

class SignInControllerFactory
{
    public function create(): ControllerInterface
    {
        $controller = new SignInController(
            validation: new SignInValidation(),
            useCase: (new SignInUseCaseFactory)->create()
        );

        return new LogControllerDecorator(
            controller: $controller,
            logRepositor: new LogMongoRepository()
        );
    }
}