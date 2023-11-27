<?php

namespace Core\Infrastructure\Persistence\MongoDb\Repository;

use Core\Domain\Shared\Repository\DbTransactionInterface;
use Core\Infrastructure\Persistence\MongoDb\Helpers\MongoHelperSingleton;
use MongoDB\Driver\Session;

class DbTransactionMongoRepository implements DbTransactionInterface
{
    private Session $session;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $client = MongoHelperSingleton::getClient();
        $this->session = $client->startSession();
    }

    public function beginTransaction(): void
    {
        $this->session->startTransaction();
    }

    public function commit(): void
    {
        $this->session->commitTransaction();
        $this->session->endSession();
    }

    public function rollback(): void
    {
        $this->session->abortTransaction();
        $this->session->endSession();
    }
}