<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Entity\SurveyResult;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Survey\Entity\Survey\SurveyQuestion;
use Core\Domain\Survey\Factory\SurveyResultValidatorFactory;
use Core\Domain\Survey\Validator\SurveyResultValidator;
use Core\Domain\Survey\ValueObject\SurveyResultAnswer;

class SurveyResult extends Entity
{

    /**
     * @param SurveyResultAnswer[] $surveyResultAnswer
     * @throws NotificationErrorException
     */
    public function __construct(
        protected SurveyQuestion $survey,
        protected string $question,
        protected array $surveyResultAnswer,
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
        SurveyResultValidatorFactory::create()->validate(entity: $this);

        if ( $this->notificationError->hasErrors() ) {
            throw NotificationErrorException::messages(
                message: $this->notificationError->messages(SurveyResultValidator::CONTEXT)
            );
        }
    }
}