<?php

namespace Core\Domain\Shared\Validator;

interface ValidatorEntityInterface
{
    public function validate(object $entity): void;
}