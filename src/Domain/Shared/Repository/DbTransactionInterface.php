<?php

declare(strict_types=1);

namespace Core\Domain\Shared\Repository;

interface DbTransactionInterface
{
    public function commit();

    public function rollback();
}