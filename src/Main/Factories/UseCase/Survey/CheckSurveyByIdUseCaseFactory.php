<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Survey;

use Core\Application\UseCase\Survey\Survey\Check\CheckSurveyByIdUseCase;

class CheckSurveyByIdUseCaseFactory
{
    public static function create(): CheckSurveyByIdUseCase
    {
        return new CheckSurveyByIdUseCase();
    }
}