<?php

namespace Core\Infrastructure\Cryptography\PasswordAdapter;

use Core\Application\Interfaces\Cryptography\HasherInterface;

class PasswordAdapter implements HasherInterface
{
    public function hash(string $plaintext): string
    {
        return password_hash(password: $plaintext, algo: PASSWORD_DEFAULT);
    }

    public function compare(string $plaintext, string $hash): bool
    {
        return password_verify(password: $plaintext, hash: $hash);
    }
}