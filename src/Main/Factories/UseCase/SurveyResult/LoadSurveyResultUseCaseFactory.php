<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\SurveyResult;

use Core\Application\UseCase\Survey\SurveyResult\LoadSurveyResult\LoadSurveyResultUseCase;

class LoadSurveyResultUseCaseFactory
{
    public static function create(): LoadSurveyResultUseCase
    {
        return new LoadSurveyResultUseCase();
    }
}