<?php

declare(strict_types=1);

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