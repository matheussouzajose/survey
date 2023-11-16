<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Factory;

use Core\Domain\Shared\Validator\DomainValidatorInterface;
use Core\Domain\Survey\Validator\SurveyValidator;

class SurveyValidatorFactory
{
    public static function create(): DomainValidatorInterface
    {
        return new SurveyValidator();
    }
}