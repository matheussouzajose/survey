<?php

namespace Core\Domain\Shared\Repository;

interface DbTransactionInterface
{
    public function commit();

    public function rollback();
}