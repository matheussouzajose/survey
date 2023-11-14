<?php

declare(strict_types=1);

namespace Core\Domain\Account\Entity;

use Core\Domain\Account\Factory\AccountValidatorFactory;
use Core\Domain\Account\Validator\AccountValidator;
use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Domain\Shared\ValueObject\Uuid;

class Account extends Entity
{
    /**
     * @throws NotificationErrorException
     */
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected string $email,
        protected string $password,
        protected ?string $accessToken = null,
        protected ?Uuid $id = null,
        protected ?\DateTimeInterface $createdAt = null,
        protected ?\DateTimeInterface $updatedAt = null
    ) {
        parent::__construct();

        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationErrorException
     */
    protected function validation(): void
    {
        AccountValidatorFactory::create()->validate(entity: $this);

        if ( $this->notificationError->hasErrors() ) {
            throw NotificationErrorException::messages(
                message: $this->notificationError->messages(AccountValidator::CONTEXT)
            );
        }
    }

    /**
     * @throws NotificationErrorException
     */
    public function changeName(string $firstName, string $lastName): void
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationErrorException
     */
    public function changeEmail(string $email): void
    {
        $this->email = $email;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    /**
     * @throws NotificationErrorException
     */
    public function changePassword(string $password): void
    {
        $this->password = $password;
        $this->updatedAt = new \DateTime();

        $this->validation();
    }

    public function changeAccessToken(string $token): void
    {
        $this->accessToken = $token;
    }

    public function fullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}