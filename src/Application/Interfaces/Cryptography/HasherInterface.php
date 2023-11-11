<?php

namespace Core\Application\Interfaces\Cryptography;

interface HasherInterface
{
    public function hash(string $plaintext): string;

    public function compare(string $plaintext, string $digest): bool;
}