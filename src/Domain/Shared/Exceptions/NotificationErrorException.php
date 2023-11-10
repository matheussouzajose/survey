<?php

namespace Core\Domain\Shared\Exceptions;

class NotificationErrorException extends \Exception
{
    public static function messages(string $message): NotificationErrorException
    {
        return new self(
            message: $message,
            code: 403
        );
    }
}