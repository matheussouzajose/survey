<?php

use Core\Application\Exception\ValidationFailedException;
use Core\Infrastructure\Validation\Account\SignUpValidation;

describe('SignUp Validator', function () {
    it('should throws when signup validator throws errors', function ( ) {
        expect(function () {
            $signUpValidator = new SignUpValidation();
            $signUpValidator->validate(input: new \stdClass());
        })->toThrow(ValidationFailedException::class);
    });
});