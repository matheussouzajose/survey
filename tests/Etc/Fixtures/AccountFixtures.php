<?php

namespace Tests\Etc\Fixtures;

use Core\Infrastructure\Persistence\Doctrine\Mapping\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture
{
    public const MATHEUS_JOSE_ID = '9ba62264-0361-4371-baaa-2536feb361f7';
    public const MATHEUS_FIRST_NAME = 'Matheus';
    public const MATHEUS_LAST_NAME = 'Jose';
    public const MATHEUS_EMAIL = 'matheus.jose@mail.com';
    public const PASSWORD_DEFAULT = '123456789';
    public const CREATED_AT_DEFAULT = '2023-01-01 12:00:00';
    public const UPDATED_AT_DEFAULT = '2023-01-01 12:00:00';

    public function load(ObjectManager $manager): void
    {
        $this->createMatheusJose(manager: $manager);

        $manager->flush();
    }

    private function createMatheusJose(ObjectManager $manager): void
    {
        $account = new Account();
        $account->setId(id: self::MATHEUS_JOSE_ID);
        $account->setFirstName(first_name: self::MATHEUS_FIRST_NAME);
        $account->setLastName(last_name: self::MATHEUS_LAST_NAME);
        $account->setEmail(email: self::MATHEUS_EMAIL);
        $account->setPassword(password: self::PASSWORD_DEFAULT);
        $account->setCreatedAt(createdAt: new \DateTime(self::CREATED_AT_DEFAULT));
        $account->setUpdatedAt(updatedAt: new \DateTime(self::UPDATED_AT_DEFAULT));

        $manager->persist($account);
    }
}