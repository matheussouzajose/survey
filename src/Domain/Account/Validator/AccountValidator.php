<?php

declare(strict_types=1);

namespace Core\Domain\Account\Validator;

use Core\Domain\Shared\Validator\DomainValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class AccountValidator implements DomainValidatorInterface
{
    public const CONTEXT = 'account';

    public function validate(object $entity): void
    {
        try {
            $validator = v::attribute(
                'firstName',
                v::stringType()->length(1, 255)
            )
                ->attribute(
                    'lastName',
                    v::stringType()->length(1, 255)
                )
                ->attribute(
                    'email',
                    v::email()
                )
                ->attribute(
                    'password',
                    v::stringType()->length(1, 255)
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