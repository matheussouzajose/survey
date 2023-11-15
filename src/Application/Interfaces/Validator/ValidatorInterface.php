<?php

declare(strict_types=1);

namespace Core\Application\Interfaces\Validator;

interface ValidatorInterface
{
    public function validate(object $input): void;
}