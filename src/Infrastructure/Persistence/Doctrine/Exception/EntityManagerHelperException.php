<?php

namespace Core\Infrastructure\Persistence\Doctrine\Exception;

class EntityManagerHelperException extends \Exception
{
    public static function error(string $message): EntityManagerHelperException
    {
        return new self(
            message: $message,
            code: 500
        );
    }
}