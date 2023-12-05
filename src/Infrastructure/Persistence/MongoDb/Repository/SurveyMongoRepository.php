<?php

namespace Core\Infrastructure\Persistence\MongoDb\Repository;

use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Survey\Entity\Survey;
use Core\Domain\Survey\Repository\SurveyRepositoryInterface;
use Core\Infrastructure\Persistence\MongoDb\Helpers\MongoHelperSingleton;

class SurveyMongoRepository implements SurveyRepositoryInterface
{

    public function add(Survey $survey): Survey
    {
        $collection = MongoHelperSingleton::getCollection('surveys');

        $collection->insertOne([
            'uuid' => $survey->id(),
            'question' => $survey->question,
            'answers' => $survey->surveyAnswerToArray(),
            'created_at' => $survey->createdAt(),
        ]);

        $result = $collection->findOne(['uuid' => $survey->id()]);

        return $this->createEntity($result);
    }

    private function createEntity($survey): Survey
    {
        $newSurvey = new Survey(
            question: $survey->question,
            id: new Uuid($survey->uuid),
            createdAt: new \DateTime($survey->created_at)
        );
        $newSurvey->addSurveyAnswersArray(surveyAnswers: $survey['answers']);

        return $newSurvey;
    }
}