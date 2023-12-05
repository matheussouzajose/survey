<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\UseCase\Account\SignIn\SignInInputDto;
use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;
use Core\Ui\Api\Validation\ValidationInterface;

class SignUpController implements ControllerInterface
{
    public function __construct(
        private readonly ValidationInterface $validation,
        private readonly SignUpUseCase $useCase,
        private readonly SignInUseCase $signInUseCase
    ) {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            $error = $this->validation->validate(input: $request);
            if ( $error ) {
                return badRequest(error: $error);
            }

            $isValid = ($this->useCase)(input: $this->createFromRequest(request: $request));
            if ( !$isValid ) {
                return forbidden(EmailAlreadyInUseException::email(email: $request->email));
            }

            $authentication = ($this->signInUseCase)(
                new SignInInputDto(
                    email: $request->email,
                    password: $request->password
                )
            );
            return ok((array)$authentication);
        } catch (\Throwable $e) {
            return serverError($e);
        }
    }

    private function createFromRequest(object $request): SignUpInputDto
    {
        return new SignUpInputDto(
            firstName: $request->first_name ?? '',
            lastName: $request->last_name ?? '',
            email: $request->email ?? '',
            password: $request->password ?? '',
            passwordConfirmation: $request->password_confirmation ?? '',
        );
    }
}