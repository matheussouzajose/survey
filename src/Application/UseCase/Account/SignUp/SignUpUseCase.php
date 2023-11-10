<?php

namespace Core\Application\UseCase\Account\SignUp;

use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Domain\Account\Entity\Account;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Exceptions\NotificationErrorException;

class SignUpUseCase
{
    public function __construct(
        protected AccountRepositoryInterface $accountRepository,
        protected HasherInterface $hasher
    ) {
    }

    /**
     * @throws EmailAlreadyInUseException|NotificationErrorException
     */
    public function __invoke(SignUpInputDto $input): SignUpOutputDto
    {
        if ( $this->accountRepository->checkByEmail(email: $input->email) ) {
            throw EmailAlreadyInUseException::email(email: $input->email);
        }

        $hashedPassword = $this->hasher->hash(plaintext: $input->password);
        $account = new Account(
            firstName: $input->firstName,
            lastName: $input->lastName,
            email: $input->email,
            password: $hashedPassword
        );
        $result = $this->accountRepository->add(account: $account);
        return $this->output(account: $result);
    }

    protected function output(Account $account): SignUpOutputDto
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