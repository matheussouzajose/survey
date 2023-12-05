<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Account;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Infrastructure\Validation\Account\SignUpValidation;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Main\Factories\UseCase\Account\SignInUseCaseFactory;
use Core\Main\Factories\UseCase\Account\SignUpUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignUpController;
use Core\Ui\Api\ControllerInterface;

class SignUpControllerFactory
{
    public function create(): ControllerInterface
    {
        $controller = new SignUpController(
            validation: new SignUpValidation(),
            useCase: (new SignUpUseCaseFactory)->create(),
            signInUseCase: (new SignInUseCaseFactory())->create()
        );

        return new LogControllerDecorator(
            controller: $controller,
            logRepositor: new LogMongoRepository()
        );
    }
}