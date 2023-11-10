<?php

namespace Core\Application\Interfaces\Cryptography;

interface HasherInterface
{
    public function hash(string $plaintext): string;
}