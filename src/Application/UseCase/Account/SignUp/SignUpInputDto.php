<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignUp;

class SignUpInputDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password,
    ) {
    }
}