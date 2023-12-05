<?php

use Core\Application\Exception\ValidationFailedException;
use Core\Infrastructure\Validation\Account\SignUpValidation;

describe('SignIn Validator', function () {
    it('should throws when signin validator throws errors', function ( ) {
        expect(function () {
            $signUpValidator = new SignUpValidation();
            $signUpValidator->validate(input: new \stdClass());
        })->toThrow(ValidationFailedException::class);
    });
});