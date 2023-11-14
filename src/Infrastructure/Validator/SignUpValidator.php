<?php

namespace Core\Infrastructure\Validator;

use Core\Application\Exception\ValidationFailedException;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class SignUpValidator implements ValidatorInterface
{
    /**
     * @throws ValidationFailedException
     */
    public function validate(object $input): void
    {
        try {
            $validator = v::attribute('firstName', v::stringType()->length(1, 255))
                ->attribute('lastName', v::stringType()->length(1, 255))
                ->attribute('email', v::email())
                ->attribute('password', v::stringType()->length(6, null))
                ->attribute('passwordConfirmation', v::equals($input->password ?? null));

            $validator->assert(input: $input);
        } catch (ValidationException $exception) {
            throw new ValidationFailedException(errors: $exception->getMessages());
        }
    }
}