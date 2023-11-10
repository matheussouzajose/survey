<?php

namespace Core\Domain\Shared\ValueObject;

use Core\Domain\Shared\Exceptions\UuidException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    /**
     * @throws UuidException
     */
    private function ensureIsValid(string $id): void
    {
        if (! RamseyUuid::isValid($id)) {
            throw UuidException::itemInvalid($id);
        }
    }
}