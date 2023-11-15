<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignIn;

class SignInInputDto
{
    public function __construct(public string $email, public string $password)
    {
    }
}