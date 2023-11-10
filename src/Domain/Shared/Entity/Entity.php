<?php

namespace Core\Domain\Shared\Entity;

use Core\Domain\Shared\Notification\NotificationError;
use Core\Domain\Shared\Traits\MethodsMagicsTrait;

abstract class Entity
{
    use MethodsMagicsTrait;

    protected NotificationError $notificationError;

    public function __construct()
    {
        $this->notificationError = new NotificationError();
    }

    public function id(): string
    {
        return (string)$this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}