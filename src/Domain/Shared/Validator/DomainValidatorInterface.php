<?php

declare(strict_types=1);

namespace Core\Domain\Shared\Validator;

interface DomainValidatorInterface
{
    public function validate(object $entity): void;
}