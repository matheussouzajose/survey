<?php

namespace Core\Domain\Account\Factory;

use Core\Domain\Account\Validator\AccountValidator;
use Core\Domain\Shared\Validator\ValidatorEntityInterface;

class AccountValidatorFactory
{
    public static function create(): ValidatorEntityInterface
    {
        return new AccountValidator();
    }
}