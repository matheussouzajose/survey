<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Survey\Add;

class AddSurveyOutputDto
{
    public function __construct(
        public string $id,
        public string $question,
        public array $answers,
        public bool $didAnswer,
        public string $createdAt,
    ) {
    }
}