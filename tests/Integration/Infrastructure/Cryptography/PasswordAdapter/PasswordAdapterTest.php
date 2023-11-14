<?php

use Core\Infrastructure\Cryptography\PasswordAdapter\PasswordAdapter;

describe('Bcrypt Adapter', function () {
    it('should ensure that the password is encrypted', function () {
        $passwordAdapter = new PasswordAdapter();
        $result = $passwordAdapter->hash(plaintext: 'password');

        expect($result)->not->toBe('password');
    });

    it('should return false when passwords is different', function () {
        $passwordAdapter = new PasswordAdapter();
        $result = $passwordAdapter->compare(plaintext: 'password', hash: 'hashed');

        expect($result)->toBeFalse();
    });

    it('should return true when passwords is the same', function () {
        $passwordAdapter = new PasswordAdapter();
        $hash = $passwordAdapter->hash(plaintext: 'password');

        $result = $passwordAdapter->compare(plaintext: 'password', hash: $hash);

        expect($result)->toBeTrue();
    });
});