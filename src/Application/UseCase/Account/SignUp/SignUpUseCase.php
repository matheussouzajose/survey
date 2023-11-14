<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignUp;

use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Event\AccountCreatedEvent;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Event\EventDispatcher;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\Repository\DbTransactionInterface;

class SignUpUseCase
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly HasherInterface $hasher,
        private readonly DbTransactionInterface $dbTransaction,
        private readonly EventDispatcher $eventDispatcher,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws EmailAlreadyInUseException|NotificationErrorException
     */
    public function __invoke(SignUpInputDto $input): SignUpOutputDto
    {
        try {
            $this->validator->validate(input: $input);
            $this->dbTransaction->beginTransaction();
            $this->checkEmailAvailability(email: $input->email);

            $result = $this->createAccount(
                input: $input,
                hashedPassword: $this->hashPassword(
                    plaintext: $input->password
                )
            );

            $this->dispatchAccountCreatedEvent($result);

            $this->dbTransaction->commit();

            return $this->output(account: $result);
        } catch (EmailAlreadyInUseException|NotificationErrorException $exception) {
            $this->dbTransaction->rollback();
            throw $exception;
        }
    }

    /**
     * @throws EmailAlreadyInUseException
     */
    private function checkEmailAvailability(string $email): void
    {
        if ( $this->accountRepository->checkByEmail($email) ) {
            throw EmailAlreadyInUseException::email($email);
        }
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

    private function output(Account $account): SignUpOutputDto
    {
        return new SignUpOutputDto(
            id: $account->id(),
            firstName: $account->firstName,
            lastName: $account->lastName,
            email: $account->email,
            createdAt: $account->createdAt(),
        );
    }
}