<?php

declare(strict_types=1);

namespace Core\Main\Factories\UseCase\Survey;

use Core\Application\UseCase\Survey\Add\AddSurveyUseCase;
use Core\Main\Factories\Repository\MongoDb\SurveyMongoRepositoryFactory;

class AddSurveyUseCaseFactory
{
    public function create(): AddSurveyUseCase
    {
        return new AddSurveyUseCase(
            surveyRepository: (new SurveyMongoRepositoryFactory())->create()
        );
    }
}