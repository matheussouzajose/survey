<?php

namespace Core\Main\Factories\Controller\Account;

use Core\Main\Factories\UseCase\SignInUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignInController;
use Core\Ui\Api\ControllerInterface;

class SignInControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new SignInController(useCase: SignInUseCaseFactory::create());
    }
}