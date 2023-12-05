<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\Survey;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Ui\Api\Controller\Survey\LoadSurveysController;
use Core\Ui\Api\ControllerInterface;

class LoadSurveysControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(
            controller: new LoadSurveysController(), logRepositor: new LogMongoRepository()
        );
    }
}