<?php

namespace Core\Main\Factories\Controller\Account;

use Core\Main\Factories\UseCase\SignUpUseCaseFactory;
use Core\Ui\Api\Controller\Account\SignUpController;
use Core\Ui\Api\ControllerInterface;

class SignUpControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new SignUpController(useCase: SignUpUseCaseFactory::create());
    }
}