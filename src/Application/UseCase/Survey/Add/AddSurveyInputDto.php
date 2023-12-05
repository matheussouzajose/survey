<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Survey\Add;

use Core\Domain\Survey\ValueObject\SurveyAnswer;

class AddSurveyInputDto
{
    /**
     * @param SurveyAnswer[] $surveyAnswers
     */
    public function __construct(public string $question, public array $surveyAnswers)
    {
    }
}