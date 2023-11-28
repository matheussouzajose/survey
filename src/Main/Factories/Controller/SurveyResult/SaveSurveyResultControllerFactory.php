<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\SurveyResult;

use Core\Infrastructure\Persistence\MongoDb\Repository\LogMongoRepository;
use Core\Main\Decorators\LogControllerDecorator;
use Core\Ui\Api\Controller\Survey\SurveyResult\SaveSurveyResultController;
use Core\Ui\Api\ControllerInterface;

class SaveSurveyResultControllerFactory
{

    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(
            controller: new SaveSurveyResultController(),
            logRepositor: new LogMongoRepository()
        );
    }
}