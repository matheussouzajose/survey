<?php

use Core\Domain\Account\Entity\Account;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Infrastructure\Persistence\Doctrine\Mapping\Account as AccountMapping;
use Core\Infrastructure\Persistence\Doctrine\Repository\AccountRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Tests\Etc\Fixtures\AccountFixtures;

describe('Account Repository', function () {
    $entityManager = setupEntityManagerAndFixtures();

    beforeEach(function () use ($entityManager) {
        beginTransaction($entityManager);
    });

    afterEach(function () use ($entityManager) {
        rollBackTransaction($entityManager);
    });

    $accountRepository = new AccountRepository(
        em: $entityManager,
        class: new ClassMetadata(AccountMapping::class)
    );

    it('should return true when email already in use', function () use ($accountRepository) {
        $exists = $accountRepository->checkByEmail(email: 'invalid_email');

        expect($exists)->toBeFalse();
    });

    it('should return false when email do not exists', function () use ($accountRepository) {
        $exists = $accountRepository->checkByEmail(email: AccountFixtures::MATHEUS_EMAIL);

        expect($exists)->toBeTrue();
    });

    it('should create new account', function () use ($accountRepository) {
        $result = $accountRepository->add(
            entity: new Account(
                firstName: 'João',
                lastName: 'Paulo',
                email: 'joao.paulo@mail.com',
                password: '$2y$10$Zwr0hmiTr/SSlMpkFLNWXeock1kbBeplngqnoVSLET17QF4SZWtDi'
            )
        );

        expect($result)->toBeInstanceOf(Account::class);
        expect($result->firstName)->toBe('João');
        expect($result->lastName)->toBe('Paulo');
        expect($result->email)->toBe('joao.paulo@mail.com');
        expect($result->password)->toBe('$2y$10$Zwr0hmiTr/SSlMpkFLNWXeock1kbBeplngqnoVSLET17QF4SZWtDi');
        expect($result->id())->not->toBeEmpty();
        expect($result->createdAt())->not->toBeEmpty();
    });

    it('should return null when account does not exists', function () use ($accountRepository) {
        $result = $accountRepository->loadByEmail(email: 'invalid@mail.com');

        expect($result)->toBeNull();
    });

    it('should return an account when account exists', function () use ($accountRepository) {
        $result = $accountRepository->loadByEmail(email: AccountFixtures::MATHEUS_EMAIL);

        expect($result)->toBeInstanceOf(Account::class);
    });

    it('should update access token of account', function () use ($accountRepository) {
        $account = new Account(
            firstName: AccountFixtures::MATHEUS_FIRST_NAME,
            lastName: AccountFixtures::MATHEUS_LAST_NAME,
            email: AccountFixtures::MATHEUS_EMAIL,
            password: AccountFixtures::PASSWORD_DEFAULT,
            id: new Uuid(AccountFixtures::MATHEUS_JOSE_ID),
            createdAt: new \DateTime(AccountFixtures::CREATED_AT_DEFAULT)
        );
        $account->changeAccessToken(token: 'new_token');

        $accountRepository->updateAccessToken(entity: $account);

        $result = $accountRepository->loadByEmail(email: AccountFixtures::MATHEUS_EMAIL);

        expect($result->accessToken)->toBe('new_token');
    });
});