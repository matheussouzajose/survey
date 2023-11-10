<?php

namespace Core\Domain\Account\Exceptions;

class EmailAlreadyInUseException extends \Exception
{
    public static function email(string $email): self
    {
        $message = sprintf('Email %s already in use.', $email);
        return new self(
            message: $message,
            code: 422
        );
    }
}