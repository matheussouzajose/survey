<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\SurveyResult;

use Core\Application\UseCase\Survey\LoadSurveys\LoadSurveysUseCase;

class SaveSurveyResultUseCaseFactory
{
    public static function create(): LoadSurveysUseCase
    {
        return new LoadSurveysUseCase();
    }
}