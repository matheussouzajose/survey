<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Survey;

use Core\Application\UseCase\Survey\Survey\LoadSurveys\LoadSurveysUseCase;

class LoadSurveysUseCaseFactory
{
    public static function create(): LoadSurveysUseCase
    {
        return new LoadSurveysUseCase();
    }
}