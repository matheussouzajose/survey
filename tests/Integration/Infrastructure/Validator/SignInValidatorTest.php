<?php

use Core\Application\Exception\ValidationFailedException;
use Core\Infrastructure\Validator\SignUpValidator;

describe('SignIn Validator', function () {
    it('should throws when signin validator throws errors', function ( ) {
        expect(function () {
            $signUpValidator = new SignUpValidator();
            $signUpValidator->validate(input: new \stdClass());
        })->toThrow(ValidationFailedException::class);
    });
});