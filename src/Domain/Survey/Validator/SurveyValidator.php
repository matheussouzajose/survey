<?php

declare(strict_types=1);

namespace Core\Domain\Survey\Validator;

use Core\Domain\Shared\Validator\DomainValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class SurveyValidator implements DomainValidatorInterface
{
    public const CONTEXT = 'survey';

    public function validate(object $entity): void
    {
        try {
            $validator = v::attribute(
                'question',
                v::stringType()->length(1, 255)
            )
                ->attribute(
                    'surveyAnswer',
                    v::arrayType()
                );

            $validator->assert(input: $entity);
        } catch (ValidationException $exception) {
            foreach ($exception->getMessages() as $error) {
                $entity->notificationError->addError([
                    'context' => self::CONTEXT,
                    'message' => $error,
                ]);
            }
        }
    }
}