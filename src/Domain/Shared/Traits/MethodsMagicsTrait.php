<?php

declare(strict_types=1);

namespace Core\Domain\Shared\Traits;

use Core\Domain\Shared\Exceptions\ClassException;

trait MethodsMagicsTrait
{
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw ClassException::propertyNotFound($property, $className);
    }
}