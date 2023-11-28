<?php

namespace Core\Domain\Account\Event\Handler;

use Core\Domain\Shared\Event\EventHandlerInterface;
use Core\Domain\Shared\Event\EventInterface;
use Core\Domain\Shared\Repository\LogRepositoryInterface;

class SaveLogWhenAccountLoggedIn implements EventHandlerInterface
{
    public function __construct(private readonly LogRepositoryInterface $logRepository)
    {
    }

    public function handle(EventInterface $event): void
    {
        $this->logRepository->logAuthenticateAction(data: [
            ...$event->eventData(),
            'created_at' => $event->dateTimeOccurred()->format('Y-m-d H:i:s')
        ]);
    }
}