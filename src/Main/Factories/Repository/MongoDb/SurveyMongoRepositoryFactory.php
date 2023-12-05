<?php

namespace Core\Main\Factories\Repository\MongoDb;

use Core\Domain\Survey\Repository\SurveyRepositoryInterface;
use Core\Infrastructure\Persistence\MongoDb\Repository\SurveyMongoRepository;

class SurveyMongoRepositoryFactory
{
    public function create(): SurveyRepositoryInterface
    {
        return new SurveyMongoRepository();
    }
}