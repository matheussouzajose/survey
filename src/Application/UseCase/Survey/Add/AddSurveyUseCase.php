<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Survey\Add;

use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Image;
use Core\Domain\Survey\Entity\Survey;
use Core\Domain\Survey\Repository\SurveyRepositoryInterface;
use Core\Domain\Survey\ValueObject\SurveyAnswer;

class AddSurveyUseCase
{
    public function __construct(
        private readonly SurveyRepositoryInterface $surveyRepository,
    ) {
    }

    /**
     * @throws NotificationErrorException
     */
    public function __invoke(AddSurveyInputDto $input): AddSurveyOutputDto
    {
        $survey = new Survey(
            question: $input->question
        );
        $survey->addSurveyAnswersArray(surveyAnswers: $input->surveyAnswers);

        $result = $this->surveyRepository->add(survey: $survey);

        return $this->output(survey: $result);
    }

    private function output(Survey $survey): AddSurveyOutputDto
    {
        return new AddSurveyOutputDto(
            id: $survey->id(),
            question: $survey->question,
            answers: $survey->surveyAnswerToArray(),
            didAnswer: $survey->didAnswer,
            createdAt: $survey->createdAt(),
        );
    }
}