<?php

declare(strict_types=1);

namespace Core\Application\Interfaces\Cryptography;

interface HasherInterface
{
    public function hash(string $plaintext): string;

    public function compare(string $plaintext, string $hash): bool;
}