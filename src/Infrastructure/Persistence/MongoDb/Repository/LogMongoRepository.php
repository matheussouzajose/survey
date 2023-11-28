<?php

namespace Core\Infrastructure\Persistence\MongoDb\Repository;

use Core\Domain\Shared\Repository\LogRepositoryInterface;
use Core\Infrastructure\Persistence\MongoDb\Helpers\MongoHelperSingleton;

class LogMongoRepository implements LogRepositoryInterface
{
    public function logError(array $errors): void
    {
        $collection = MongoHelperSingleton::getCollection('log_errors');
        $collection->insertOne([
            'message' => $errors['message'],
            'trace' => $errors['trace'],
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);
    }

    public function logAuthenticateAction(array $data): void
    {
        $collection = MongoHelperSingleton::getCollection('log_authentication_action');
        $collection->insertOne($data);
    }
}