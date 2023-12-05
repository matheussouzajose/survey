<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Survey;

use Core\Application\UseCase\Survey\LoadAnswers\LoadAnswersBySurveyUseCase;

class LoadAnswersBySurveyUseCaseFactory
{
    public static function create(): LoadAnswersBySurveyUseCase
    {
        return new LoadAnswersBySurveyUseCase();
    }
}