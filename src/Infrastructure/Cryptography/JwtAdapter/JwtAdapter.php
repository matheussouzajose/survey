<?php

namespace Core\Infrastructure\Cryptography\JwtAdapter;

use Core\Application\Interfaces\Cryptography\EncrypterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAdapter implements EncrypterInterface
{
    public function __construct(private readonly string $secretKey)
    {
    }

    public function encrypt(string $plaintext): string
    {
        $payload = [
            'iss' => 'http://example.com',
            'aud' => 'http://example.org',
            'iat' => time(),
            'exp' => time() + 3600,
            'user_id' => $plaintext,
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function decrypt(string $ciphertext): string
    {
        $decoded = JWT::decode($ciphertext, new Key($this->secretKey, 'HS256'));
        return $decoded->user_id;
    }
}