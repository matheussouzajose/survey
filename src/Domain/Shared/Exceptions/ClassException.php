<?php

namespace Core\Domain\Shared\Exceptions;

class ClassException extends \InvalidArgumentException
{
    public static function propertyNotFound(string $property, string $className): ClassException
    {
        $message = sprintf('Property %s not found in class %s', $property, $className);

        return new self(
            message: $message,
            code: 403
        );
    }
}