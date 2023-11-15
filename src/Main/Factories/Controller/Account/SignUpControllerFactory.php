<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Account;

use Core\Main\Decorators\LogControllerDecorator;
use Core\Main\Factories\UseCase\Account\SignUpUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignUpController;
use Core\Ui\Api\ControllerInterface;

class SignUpControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(controller: new SignUpController(useCase: SignUpUseCaseFactory::create()));
    }
}