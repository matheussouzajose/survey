<?php

use Core\Infrastructure\Cryptography\JwtAdapter\JwtAdapter;

describe('Jwt Adapter', function () {
    it('should encrypt token and return user id', function () {
        $jwtAdapter = new JwtAdapter(secretKey: 'SECRET');
        $token = $jwtAdapter->encrypt('user_id');

        $decoded =$jwtAdapter->decrypt($token);

        expect($decoded)->toBe('user_id');
    });
});