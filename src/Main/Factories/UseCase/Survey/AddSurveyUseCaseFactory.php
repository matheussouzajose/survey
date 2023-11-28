<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Survey;

use Core\Application\UseCase\Survey\Survey\Add\AddSurveyUseCase;

class AddSurveyUseCaseFactory
{
    public static function create(): AddSurveyUseCase
    {
        return new AddSurveyUseCase();
    }
}