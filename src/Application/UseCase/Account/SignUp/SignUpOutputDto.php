<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignUp;

class SignUpOutputDto
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $createdAt,
    ) {
    }
}