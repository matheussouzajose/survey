<?php

declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Doctrine\Repository;

use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Account as AccountMapping;
use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository implements AccountRepositoryInterface
{
    public function checkByEmail(string $email): bool
    {
        $user = $this->findOneBy(['email' => $email]);
        return ($user !== null);
    }

    /**
     * @throws NotificationErrorException
     */
    public function add(Account $entity): Account
    {
        $accountMapping = new AccountMapping();
        $accountMapping->setId(id: $entity->id());
        $accountMapping->setFirstName(first_name: $entity->firstName);
        $accountMapping->setLastName(last_name: $entity->lastName);
        $accountMapping->setEmail(email: $entity->email);
        $accountMapping->setPassword(password: $entity->password);
        $accountMapping->setCreatedAt(createdAt: $entity->createdAt);

        $em = $this->getEntityManager();
        $em->persist($accountMapping);
        $em->flush();

        return $this->createEntity(account: $accountMapping);
    }

    /**
     * @throws NotificationErrorException
     */
    private function createEntity(AccountMapping $account): Account
    {
        return new Account(
            firstName: $account->getFirstName(),
            lastName: $account->getLastName(),
            email: $account->getEmail(),
            password: $account->getPassword(),
            id: new Uuid($account->getId()),
            createdAt: $account->getCreatedAt(),
        );
    }
}