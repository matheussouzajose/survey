<?php

namespace Core\Infrastructure\Validation\Survey;

use Core\Application\Exception\ValidationFailedException;
use Core\Ui\Api\Validation\ValidationInterface;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class AddSurveyValidation implements ValidationInterface
{
    /**
     * @throws ValidationFailedException
     */
    public function validate(object $input): array
    {
        try {

            $answerValidator = v::arrayType()->each(
                v::key('answer', v::stringType()->notEmpty()),
                v::key('image', v::stringType()->notEmpty())
            );

            $validator = v::keySet(
                v::key('question', v::stringType()->notEmpty()),
                v::key('answers', $answerValidator)
            );

            $validator->assert(input: (array)$input);

            return [];
        } catch (ValidationException $exception) {
            return $exception->getMessages();
        }
    }
}