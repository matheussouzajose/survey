<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Survey;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Ui\Api\Controller\Survey\Survey\AddSurveyController;
use Core\Ui\Api\ControllerInterface;

class AddSurveyControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(
            controller: new AddSurveyController(), logRepositor: new LogMongoRepository()
        );
    }
}