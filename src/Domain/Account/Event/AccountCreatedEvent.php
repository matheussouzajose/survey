<?php

declare(strict_types=1);

namespace Core\Domain\Account\Event;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\Event\EventInterface;

class AccountCreatedEvent implements EventInterface
{
    public function __construct(protected Account $account)
    {
    }

    public function dateTimeOccurred(): \DateTimeInterface
    {
        // TODO: Implement dateTimeOccurred() method.
    }

    public function eventData()
    {
        // TODO: Implement eventData() method.
    }
}