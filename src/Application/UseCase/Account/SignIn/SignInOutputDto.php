<?php

declare(strict_types=1);

namespace Core\Application\UseCase\Account\SignIn;

class SignInOutputDto
{
    public function __construct(public array $authentication, public string $name)
    {
    }
}