<?php

namespace Core\Domain\Shared\Repository;

interface LogRepositoryInterface
{
    public function logError(array $errors): void;

    public function logAuthenticateAction(array $data);
}