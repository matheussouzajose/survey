<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Survey;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Infrastructure\Validation\Survey\AddSurveyValidation;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Main\Factories\UseCase\Survey\AddSurveyUseCaseFactory;
use Core\Ui\Api\Controller\Survey\AddSurveyController;
use Core\Ui\Api\ControllerInterface;

class AddSurveyControllerFactory
{
    public static function create(): ControllerInterface
    {
        $controller = new AddSurveyController(
            validation: new AddSurveyValidation(),
            useCase: (new AddSurveyUseCaseFactory())->create()
        );

        return new LogControllerDecorator(
            controller: $controller,
            logRepositor: new LogMongoRepository()
        );
    }
}