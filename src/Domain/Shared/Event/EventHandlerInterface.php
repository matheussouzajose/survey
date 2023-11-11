<?php

namespace Core\Domain\Shared\Event;

interface EventHandlerInterface
{
    public function handle(EventInterface $event): void;
}