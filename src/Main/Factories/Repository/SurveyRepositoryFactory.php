<?php

namespace Core\Main\Factories\Repository;

use Core\Domain\Survey\Repository\SurveyRepositoryInterface;
use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Survey;
use Core\Infrastructure\Persistence\Doctrine\Repository\SurveyRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class SurveyRepositoryFactory
{
    public static function create(): SurveyRepositoryInterface
    {
        return new SurveyRepository(
            em: EntityManagerHelperSingleton::getInstance(),
            class: new ClassMetadata(Survey::class)
        );
    }
}