<?php

declare(strict_types=1);

namespace Core\Domain\Account\Factory;

use Core\Domain\Account\Validator\AccountValidator;
use Core\Domain\Shared\Validator\DomainValidatorInterface;

class AccountValidatorFactory
{
    public static function create(): DomainValidatorInterface
    {
        return new AccountValidator();
    }
}