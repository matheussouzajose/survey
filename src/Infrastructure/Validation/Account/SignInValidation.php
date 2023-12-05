<?php

declare(strict_types=1);

namespace Core\Infrastructure\Validation\Account;

use Core\Application\Exception\ValidationFailedException;
use Core\Ui\Api\Validation\ValidationInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class SignInValidation implements ValidationInterface
{
    /**
     * @throws ValidationFailedException
     */
    public function validate(object $input): array
    {
        try {
            $validator = v::attribute('email', v::email())
                ->attribute('password', v::stringType()->length(6, null));
            $validator->assert(input: $input);

            return [];
        } catch (ValidationException $exception) {
            return $exception->getMessages();
        }
    }
}