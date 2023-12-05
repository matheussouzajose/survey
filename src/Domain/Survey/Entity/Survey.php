<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Entity;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Image;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Survey\Factory\SurveyValidatorFactory;
use Core\Domain\Survey\Validator\SurveyValidator;
use Core\Domain\Survey\ValueObject\SurveyAnswer;

class Survey extends Entity
{
    /**
     * @param SurveyAnswer[] $surveyAnswer
     * @throws NotificationErrorException
     */
    public function __construct(
        protected string $question,
        protected ?array $surveyAnswer = [],
        protected bool $didAnswer = false,
        protected ?Uuid $id = null,
        protected ?\DateTimeInterface $createdAt = null,
        protected ?\DateTimeInterface $updatedAt = null
    ) {
        parent::__construct();

        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationErrorException
     */
    protected function validation(): void
    {
        SurveyValidatorFactory::create()->validate(entity: $this);

        if ( $this->notificationError->hasErrors() ) {
            throw NotificationErrorException::messages(
                message: $this->notificationError->messages(SurveyValidator::CONTEXT)
            );
        }
    }

    public function changeQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function addSurveyAnswer(SurveyAnswer $surveyAnswer): void
    {
        $this->surveyAnswer[] = $surveyAnswer;
    }

    public function didAnswer(): void
    {
        $this->didAnswer = true;
    }

    public function didNotAnswer(): void
    {
        $this->didAnswer = false;
    }

    public function surveyAnswerToArray(): array
    {
        $surveyAnswersArray = [];
        foreach ($this->surveyAnswer as $answer) {
            $surveyAnswersArray[] = [
                'answer' => $answer->answer(),
                'image' => $answer->image()?->path(),
            ];
        }
        return $surveyAnswersArray;
    }

    public function addSurveyAnswersArray($surveyAnswers): void
    {
        foreach ($surveyAnswers as $surveyAnswer) {
            $this->addSurveyAnswer(
                new SurveyAnswer(
                    answer: $surveyAnswer['answer'],
                    image: isset($surveyAnswer['image']) ? new Image($surveyAnswer['image']) : null
                )
            );
        }
    }
}