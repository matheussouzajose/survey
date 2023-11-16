<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Validator;

use Core\Domain\Shared\Validator\DomainValidatorInterface;

class SurveyResultValidator implements DomainValidatorInterface
{
    public const CONTEXT = 'survey-result';

    public function validate(object $entity): void
    {
        // TODO: Implement validate() method.
    }
}