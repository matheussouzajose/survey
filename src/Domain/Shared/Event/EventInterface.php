<?php

declare(strict_types=1);

namespace Core\Domain\Shared\Event;

interface EventInterface
{
    public function dateTimeOccurred(): \DateTimeInterface;

    public function eventData();
}