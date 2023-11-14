<?php

namespace Core\Application\Interfaces\Validator;

interface ValidatorInterface
{
    public function validate(object $input): void;
}