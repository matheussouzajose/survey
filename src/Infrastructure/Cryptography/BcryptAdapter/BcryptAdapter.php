<?php

namespace Core\Infrastructure\Cryptography\BcryptAdapter;

use Core\Application\Interfaces\Cryptography\HasherInterface;

class BcryptAdapter implements HasherInterface
{
    public function hash(string $plaintext): string
    {
        // TODO: Implement hash() method.
    }

    public function compare(string $plaintext, string $digest): bool
    {
        // TODO: Implement compare() method.
    }
}