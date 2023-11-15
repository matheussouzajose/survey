<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignIn;

use Core\Application\Exception\InvalidCredentialsException;
use Core\Application\Interfaces\Cryptography\EncrypterInterface;
use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Application\Interfaces\Validator\ValidatorInterface;
use Core\Domain\Account\Repository\AccountRepositoryInterface;

class SignInUseCase
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly HasherInterface $hasher,
        private readonly EncrypterInterface $encrypter
    ) {
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function __invoke(SignInInputDto $input): SignInOutputDto
    {
        $this->validator->validate(input: $input);

        $account = $this->accountRepository->loadByEmail(email: $input->email);
        if ( !$account ) {
            throw InvalidCredentialsException::error();
        }

        if ( !$this->hasher->compare(plaintext: $input->password, hash: $account->password) ) {
            throw InvalidCredentialsException::error();
        }

        $accessToken = $this->encrypter->encrypt(plaintext: $account->id());

        $account->changeAccessToken(token: $accessToken);
        $this->accountRepository->updateAccessToken(entity: $account);

        return $this->output(accessToken: $accessToken, name: $account->fullName());
    }

    private function output(string $accessToken, string $name): SignInOutputDto
    {
        return new SignInOutputDto(
            accessToken: $accessToken,
            name: $name
        );
    }
}