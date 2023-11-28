<?php

namespace Core\Domain\Account\Event;

use Core\Domain\Shared\Event\EventInterface;

class AccountAuthenticatedEvent implements EventInterface
{
    public function __construct(protected array $data)
    {
    }

    public function dateTimeOccurred(): \DateTimeInterface
    {
        return new \DateTime();
    }

    public function eventData(): array
    {
        return $this->data;
    }
}