<?php

declare(strict_types=1);

namespace Core\Application\Exception;

class InvalidCredentialsException extends \Exception
{
    public static function error(): InvalidCredentialsException
    {
        return new self(
            message: 'Invalid email or password.',
            code: 401
        );
    }
}