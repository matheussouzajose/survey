<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Entity\Survey;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Survey\Factory\SurveyValidatorFactory;
use Core\Domain\Survey\Validator\SurveyValidator;

class SurveyAnswer extends Entity
{
    /**
     * @param SurveyAnswer[] $surveyAnswer
     * @throws NotificationErrorException
     */
    public function __construct(
        protected string $surveyQuestion,
        protected array $surveyAnswer,
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
}