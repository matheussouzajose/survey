<?php

declare(strict_types=1);

namespace Core\Ui\Api;

interface ValidatorRequestInterface
{
    public function validate(object $input): ?array;
}