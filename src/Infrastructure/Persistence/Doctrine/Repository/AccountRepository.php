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
        $accountMapping = $this->findOneBy(['email' => $email]);
        return ($accountMapping !== null);
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
        $accountMapping->setCreatedAt(created_at: $entity->createdAt);

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
            accessToken: $account->getAccessToken(),
            id: new Uuid($account->getId()),
            createdAt: $account->getCreatedAt()
        );
    }

    /**
     * @throws NotificationErrorException
     */
    public function loadByEmail(string $email): ?Account
    {
        $accountMapping = $this->findOneBy(['email' => $email]);
        if ( !$accountMapping ) {
            return null;
        }
        return $this->createEntity(account: $accountMapping);
    }

    public function updateAccessToken(Account $entity): bool
    {
        $accountMapping = $this->find(id: $entity->id());
        if ( !$accountMapping ) {
            return false;
        }
        $accountMapping->setAccessToken(access_token: $entity->accessToken);

        $em = $this->getEntityManager();
        $em->persist($accountMapping);
        $em->flush();

        return true;
    }

    /**
     * @throws NotificationErrorException
     */
    public function loadByToken(string $token): ?Account
    {
        $accountMapping = $this->findOneBy(['access_token' => $token]);
        if ( !$accountMapping ) {
            return null;
        }
        return $this->createEntity(account: $accountMapping);
    }

}