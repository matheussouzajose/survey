<?php

use Core\Infrastructure\Persistence\Doctrine\Helper\EntityManagerHelperSingleton;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Account;
use Core\Infrastructure\Persistence\Doctrine\Repository\DbTransaction;
use Tests\Etc\Fixtures\AccountFixtures;

describe('DbTransaction Test', function () {

    beforeEach(function () {
        $entityManager = EntityManagerHelperSingleton::getInstance();
        $account = $entityManager->getRepository(Account::class)->find('9ba62264-0361-4371-baaa-2536feb361f8');
        if ($account) {
            $entityManager->remove($account);
            $entityManager->flush();
        }

    });
    function createAccount(): Account
    {
        $account = new Account();
        $account->setId(id: '9ba62264-0361-4371-baaa-2536feb361f8');
        $account->setFirstName(first_name: 'João');
        $account->setLastName(last_name: 'Pedro');
        $account->setEmail(email: 'joao.pedro@mail.com');
        $account->setPassword(password: AccountFixtures::PASSWORD_DEFAULT);
        $account->setCreatedAt(createdAt: new \DateTime(AccountFixtures::CREATED_AT_DEFAULT));

        return $account;
    }

    function getResult()
    {
        $entityManager = EntityManagerHelperSingleton::getInstance();
        $query = $entityManager->createQuery(
            '
        SELECT u
        FROM Core\Infrastructure\Persistence\Doctrine\Mapping\Account u
        WHERE u.email = :email
    '
        );

        $query->setParameter('email', 'joao.pedro@mail.com');
        return $query->getResult();
    }

    it('should ensure that it will be saved after commit', function () {
        $dbTransaction = new DbTransaction();
        $dbTransaction->beginTransaction();

        $entityManager = EntityManagerHelperSingleton::getInstance();

        $account = createAccount();

        $entityManager->persist(entity: $account);
        $entityManager->flush();

        $dbTransaction->commit();

        expect(getResult())->toHaveCount(1);
    });

    it('should ensure that it will not be saved after rollback', function () {
        $dbTransaction = new DbTransaction();
        $dbTransaction->beginTransaction();

        $entityManager = EntityManagerHelperSingleton::getInstance();

        $account = createAccount();

        $entityManager->persist(entity: $account);
        $entityManager->flush();

        $dbTransaction->rollback();

        expect(getResult())->toHaveCount(0);
    });
});