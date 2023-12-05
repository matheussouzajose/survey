<?php

namespace Core\Ui\Api\Validation;

interface ValidationInterface
{
    public function validate(object $input): array;
}