<?php

declare(strict_types=1);

namespace Core\Domain\Shared\Validator;

interface ValidatorEntityInterface
{
    public function validate(object $entity): void;
}