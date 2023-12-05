<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignUp;

use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Event\AccountCreatedEvent;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Domain\Shared\Exceptions\NotificationErrorException;

class SignUpUseCase
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly HasherInterface $hasher,
        private readonly EventDispatcher $eventDispatcher
    ) {
    }

    /**
     * @throws NotificationErrorException
     */
    public function __invoke(SignUpInputDto $input): bool
    {
        if ( $this->accountRepository->checkByEmail($input->email) ) {
            return false;
        }

        $result = $this->createAccount(
            input: $input,
            hashedPassword: $this->hashPassword(
                plaintext: $input->password
            )
        );

        $this->dispatchAccountCreatedEvent($result);

        return true;
    }

    private function hashPassword(string $plaintext): string
    {
        return $this->hasher->hash($plaintext);
    }

    /**
     * @throws NotificationErrorException
     */
    private function createAccount(SignUpInputDto $input, string $hashedPassword): Account
    {
        return $this->accountRepository->add(
            new Account(
                firstName: $input->firstName,
                lastName: $input->lastName,
                email: $input->email,
                password: $hashedPassword
            )
        );
    }

    private function dispatchAccountCreatedEvent(Account $account): void
    {
        $this->eventDispatcher->notify(new AccountCreatedEvent(account: $account));
    }
}