<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\UseCase\Account\SignIn\SignInInputDto;
use Core\Application\UseCase\Account\SignIn\SignInUseCase;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\ControllerInterface;
use Core\Ui\Api\Validation\ValidationInterface;

class SignInController implements ControllerInterface
{
    public function __construct(
        private readonly ValidationInterface $validation,
        private readonly SignInUseCase $useCase,
    ) {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            $error = $this->validation->validate(input: $request);
            if ( $error ) {
                return badRequest(error: $error);
            }

            $authentication = ($this->useCase)(input: $this->createFromRequest(request: $request));
            if ( !$authentication ) {
                return unauthorized();
            }

            return ok((array)$authentication);
        } catch (\Throwable $e) {
            return serverError($e);
        }
    }

    private function createFromRequest(object $request): SignInInputDto
    {
        return new SignInInputDto(
            email: $request->email ?? '',
            password: $request->password ?? '',
        );
    }
}