<?php

namespace Core\Application\Exception;

class ValidationFailedException extends \Exception
{
    public static function error(array $errors): ValidationFailedException
    {
        return new self(
            message: json_encode($errors),
            code: 422
        );
    }
}