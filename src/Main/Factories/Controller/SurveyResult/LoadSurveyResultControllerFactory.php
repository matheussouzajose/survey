<?php

declare(strict_types=1);

namespace Core\Main\Factories\Controller\SurveyResult;

use Core\Main\Decorators\LogControllerDecorator;
use Core\Ui\Api\Controller\Survey\SurveyResult\LoadSurveyResultController;
use Core\Ui\Api\ControllerInterface;

class LoadSurveyResultControllerFactory
{
    public static function create(): ControllerInterface
    {
        return new LogControllerDecorator(controller: new LoadSurveyResultController());
    }
}