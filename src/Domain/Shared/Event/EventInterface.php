<?php

namespace Core\Domain\Shared\Event;

interface EventInterface
{
    public function dateTimeOccurred(): \DateTimeInterface;

    public function eventData();
}