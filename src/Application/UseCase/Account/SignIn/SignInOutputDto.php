<?php

namespace Core\Application\UseCase\Account\SignIn;

class SignInOutputDto
{
    public function __construct(public string $accessToken, public string $name)
    {
    }
}