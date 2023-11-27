<?php

namespace Core\Infrastructure\Persistence\MongoDb\Repository;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Infrastructure\Persistence\MongoDb\Helpers\MongoHelperSingleton;
use Core\Infrastructure\Persistence\MongoDb\Helpers\QueryBuilder;

class AccountMongoRepository implements AccountRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function checkByEmail(string $email): bool
    {
        $collection = MongoHelperSingleton::getCollection('accounts');
        $filter = ['email' => $email];
        $options = ['projection' => ['uuid' => 1]];
        $account = $collection->findOne($filter, $options);

        return !is_null($account);
    }

    /**
     * @throws NotificationErrorException
     * @throws \Exception
     */
    public function add(Account $entity): Account
    {
        $collection = MongoHelperSingleton::getCollection('accounts');
        $collection->insertOne([
            'uuid' => $entity->id(),
            'first_name' => $entity->firstName,
            'last_name' => $entity->lastName,
            'email' => $entity->email,
            'password' => $entity->password,
            'created_at' => $entity->createdAt(),
        ]);

        $result = $collection->findOne(['uuid' => $entity->id()]);

        return $this->createEntity($result);
    }

    /**
     * @throws NotificationErrorException
     */
    public function loadByEmail(string $email): ?Account
    {
        $collection = MongoHelperSingleton::getCollection('accounts');
        $account = $collection->findOne(['email' => $email]);

        return $account ? $this->createEntity($account) : null;
    }

    public function updateAccessToken(Account $entity): bool
    {
        $builder = new QueryBuilder();
        $builder->set(['access_token' => $entity->accessToken]);

        $collection = MongoHelperSingleton::getCollection('accounts');
        $result = $collection->updateOne([
            'uuid' => $entity->id()
        ], $builder->build());

        return $result->getModifiedCount();
    }

    public function loadByToken(string $token): ?Account
    {
        $collection = MongoHelperSingleton::getCollection('accounts');
        $account = $collection->findOne(['access_token' => $token]);

        return $account ? $this->createEntity($account) : null;
    }

    /**
     * @throws NotificationErrorException
     */
    private function createEntity($account): Account
    {
        return new Account(
            firstName: $account->first_name,
            lastName: $account->last_name,
            email: $account->email,
            password: $account->password,
            accessToken: $account->access_token ?? null,
            id: new Uuid($account->uuid),
            createdAt: new \DateTime($account->created_at)
        );
    }
}