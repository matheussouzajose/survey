<?php

declare(strict_types=1);

namespace Core\Ui\Api\Controller\Account;

use Core\Application\Exception\ValidationFailedException;
use Core\Application\UseCase\Account\SignUp\SignUpInputDto;
use Core\Application\UseCase\Account\SignUp\SignUpUseCase;
use Core\Domain\Account\Exceptions\EmailAlreadyInUseException;
use Core\Domain\Shared\Exceptions\NotificationErrorException;
use Core\Ui\Api\Adapter\Http\HttpResponseAdapter;
use Core\Ui\Api\Adapter\Http\HttpResponseHelper;
use Core\Ui\Api\ControllerInterface;

class SignUpController implements ControllerInterface
{
    public function __construct(private readonly SignUpUseCase $useCase)
    {
    }

    public function __invoke(object $request): HttpResponseAdapter
    {
        try {
            $response = ($this->useCase)(input: $this->createFromRequest(request: $request));
            return HttpResponseHelper::created((array)$response);
        } catch (EmailAlreadyInUseException|NotificationErrorException|ValidationFailedException $e) {
            return $this->handleApplicationException($e);
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

    private function handleApplicationException($e): HttpResponseAdapter
    {
        if ( $e instanceof ValidationFailedException || $e instanceof NotificationErrorException ) {
            return HttpResponseHelper::unprocessable(errors: $e->getErrors());
        }

        if ( $e instanceof EmailAlreadyInUseException ) {
            return HttpResponseHelper::conflict(error: $e->getMessage());
        }

        return HttpResponseHelper::serverError();
    }
}