<?php

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Ui\Api\Controller\Account\SignUpController;

describe('Sign Up Controller', function () {
    it('Should ensure sign up account success', function () {
        $useCase = spy(SignUpUseCase::class);

        $controller = new SignUpController(useCase: $useCase);

        $request = new \stdClass();
        $request->first_name = 'Matheus';
        $request->last_name = 'Jose';
        $request->email = 'matheus.jose@mail.com';
        $request->password = '123456789';
        $request->password_confirmation = '123456789';

        $result = ($controller)($request);

        expect($result->getStatusCode())->toBe(201);
        expect($result->getBody())->toBeArray();
    });
});