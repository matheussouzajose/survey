<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignIn;

use Core\Application\Interfaces\Cryptography\EncrypterInterface;
use Core\Application\Interfaces\Cryptography\HasherInterface;
use Core\Domain\Account\Event\AccountAuthenticatedEvent;
use Core\Domain\Account\Repository\AccountRepositoryInterface;
use Core\Domain\Shared\Event\EventDispatcherInterface;

class SignInUseCase
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly HasherInterface $hasher,
        private readonly EncrypterInterface $encrypter,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function __invoke(SignInInputDto $input): ?SignInOutputDto
    {
        $account = $this->accountRepository->loadByEmail(email: $input->email);
        if ( !$account ) {
            return null;
        }

        if ( !$this->hasher->compare(plaintext: $input->password, hash: $account->password) ) {
            return null;
        }

        $accessToken = $this->encrypter->encrypt(plaintext: $account->id());

        $account->changeAccessToken(token: $accessToken);
        $this->accountRepository->updateAccessToken(entity: $account);

        $this->dispatchAccountAuthenticatedEvent([
            'user_id' => $account->id(),
            'action' => 'login',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
            'device_info' => [
                'device_type' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            ]
        ]);

        return $this->output(accessToken: $accessToken, name: $account->fullName());
    }

    private function dispatchAccountAuthenticatedEvent(array $data): void
    {
        $this->eventDispatcher->notify(event: new AccountAuthenticatedEvent($data));
    }

    private function output(string $accessToken, string $name): SignInOutputDto
    {
        return new SignInOutputDto(
            authentication: [
                'access_token' => $accessToken,
                'token_type' => 'Bearer'
            ],
            name: $name
        );
    }
}