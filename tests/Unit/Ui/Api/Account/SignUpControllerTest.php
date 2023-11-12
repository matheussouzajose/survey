<?php

use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Ui\Api\Controller\Account\SignUpController;
use Core\Ui\Api\Validator\SignUpValidatorRequest;

describe('', function () {
    it('', function () {
        $useCase = spy(SignUpUseCase::class);
        $validation = new SignUpValidatorRequest();

        $controller = new SignUpController(useCase: $useCase, validation: $validation);

        $request = new \stdClass();
        $request->first_name = 'Matheus';
        $request->last_name = 'Jose';
        $request->email = 'matheus.jose@mail.com';
        $request->password = '123456789';
        $request->password_confirmation = '123456789';

        var_dump(($controller)($request)->getBody());
    })->only();
});