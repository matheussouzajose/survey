<?php

namespace Core\Infrastructure\Validator;

use Core\Application\Exception\ValidationFailedException;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class SignInValidator implements ValidatorInterface
{
    /**
     * @throws ValidationFailedException
     */
    public function validate(object $input): void
    {
        try {
            $validator = v::attribute('email', v::email())
                ->attribute('password', v::stringType()->length(6, null));
            $validator->assert(input: $input);
        } catch (ValidationException $exception) {
            throw new ValidationFailedException(errors: $exception->getMessages());
        }
    }
}